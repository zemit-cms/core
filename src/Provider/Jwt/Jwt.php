<?php

namespace Zemit\Provider\Jwt;

use Phalcon\Security\JWT\Builder;
use Phalcon\Security\JWT\Exceptions\ValidatorException;
use Phalcon\Security\JWT\Signer\Hmac;
use Phalcon\Security\JWT\Token\Parser;
use Phalcon\Security\JWT\Signer\AbstractSigner;
use Phalcon\Security\JWT\Token\Token;
use Phalcon\Security\JWT\Validator;

/**
 * allow you to issue, parse and validate JSON Web Tokens as described in RFC 7519.
 *
 * Builder (Phalcon\Security\JWT\Builder)
 * Parser (Phalcon\Security\JWT\Token\Parser)
 * Validator (Phalcon\Security\JWT\Validator)
 */
class Jwt
{
    public array $options;
    public Builder $builder;
    public Parser $parser;
    public Validator $validator;
    public AbstractSigner $signer;
    public Token $token;
    
    /**
     * @throws \Exception
     */
    public function __construct(array $defaultOptions = [])
    {
        $this->options = $defaultOptions;
        $this->signer();
    }
    
    /**
     * Initialize JWT Signer
     * @param string|null $signer
     * @param string|null $algo
     * @return AbstractSigner
     * @throws \Exception
     */
    public function signer(string $signer = null, string $algo = null): AbstractSigner {
        $signer ??= $this->options['signer'] ?? Hmac::class;
        $algo ??= $this->options['algo'] ?? 'sha512';
    
        $this->signer = new $signer($algo);
        
        if (!($this->signer instanceof AbstractSigner)) {
            throw new \Exception('Signer must be an instance of `' . AbstractSigner::class . '`.');
        }
        
        return $this->signer;
    }
    
    /**
     * Initialize JWT Builder
     * @param array $options
     * @return Builder
     * @throws ValidatorException
     */
    public function builder(array $options = []): Builder {
        $options = $this->getDefaultOptions($options);
        
        $this->builder = new Builder($this->signer);
        $this->builder->setPassphrase($options['passphrase']);
        $this->builder->setExpirationTime($options['expiration']);
        $this->builder->setNotBefore($options['notBefore']);
        $this->builder->setIssuedAt($options['issuedAt']);
        $this->builder->setIssuer($options['issuer']);
        $this->builder->setAudience($options['audience']);
        $this->builder->setContentType($options['contentType']);
        $this->builder->setId($options['id']);
        $this->builder->setSubject($options['subject']);
        
        return $this->builder;
    }
    
    /**
     * Initialize JWT Parser
     * @return Parser
     */
    public function parser(): Parser {
        $this->parser = new Parser();
        return $this->parser;
    }
    
    /**
     * Initialize JWT Validator
     * @param Token|null $token
     * @param int $timeShift
     * @return Validator'
     */
    public function validator(Token $token = null, int $timeShift = 0): Validator {
        $token ??= $this->token;
        
        $this->validator = new Validator($token, $timeShift);
        
        return $this->validator;
    }
    
    /**
     * @param Builder|null $builder
     * @return Token
     * @throws ValidatorException
     */
    public function buildToken(Builder $builder = null): Token {
        $builder ??= $this->builder;
        
        $this->token = $builder->getToken();
        
        return $this->token;
    }
    
    /**
     * @param string $token
     * @return Token
     */
    public function parseToken(string $token): Token {
        $parser = $this->parser();
        
        $this->token = $parser->parse($token);
        
        return $this->token;
    }
    
    /**
     * @param Token|null $token
     * @param int $timeShift
     * @param array $options
     * @param AbstractSigner|null $signer
     * @return void
     * @throws ValidatorException
     */
    public function validateToken(Token $token = null, int $timeShift = 0, array $options = [], AbstractSigner $signer = null): void {
        $token ??= $this->token;
        $signer ??= $this->signer;
        $options['expiration'] ??= strtotime('now');
        $options['notBefore'] ??= strtotime('+5 sec');
        $options['issuedAt'] ??= strtotime('+5 sec');
        $options = $this->getDefaultOptions($options);
        
        $this->validator = $this->validator($token, $timeShift);
    
        $this->validator->validateId($options['id']);
        $this->validator->validateIssuer($options['issuer']);
        $this->validator->validateAudience($options['audience']);
        $this->validator->validateNotBefore($options['notBefore']);
        $this->validator->validateExpiration($options['expiration']);
        $this->validator->validateIssuedAt($options['issuedAt']);
        $this->validator->validateSignature($signer, $options['passphrase']);
    }
    
    /**
     * Get default JWT Builder Options
     * @param array $options
     * @return array
     */
    public function getDefaultOptions(array $options = []): array {
        
        $options['expiration'] ??= $this->options['expiration'] ?? null;
        $options['notBefore'] ??= $this->options['notBefore'] ?? null;
        $options['issuedAt'] ??= $this->options['issuedAt'] ?? null;
        $options['issuer'] ??= $this->options['issuer'] ?? null;
        $options['audience'] ??= $this->options['audience'] ?? null;
        $options['contentType'] ??= $this->options['contentType'] ?? null;
        $options['passphrase'] ??= $this->options['passphrase'] ?? null;
        $options['id'] ??= $this->options['id'] ?? null;
        $options['subject'] ??= $this->options['subject'] ?? null;
        
        return $options;
    }
}
