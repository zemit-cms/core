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
 * Issue, parse and validate JSON Web Tokens (JWT) as described in RFC 7519.
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
    
    public function __construct(array $defaultOptions = [])
    {
        $this->options = $defaultOptions;
        $this->signer();
    }
    
    /**
     * Initialize JWT Signer
     */
    public function signer(string $signer = null, string $algo = null): AbstractSigner
    {
        $signer ??= $this->options['signer'] ?? Hmac::class;
        $algo ??= $this->options['algo'] ?? 'sha512';
        $this->signer = new $signer($algo);
        return $this->signer;
    }
    
    /**
     * Initialize JWT Builder and validate it
     * @throws ValidatorException
     */
    public function builder(array $options = []): Builder
    {
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
     */
    public function parser(): Parser
    {
        $this->parser = new Parser();
        return $this->parser;
    }
    
    /**
     * Initialize JWT Validator
     */
    public function validator(Token $token = null, int $timeShift = 0): Validator
    {
        $token ??= $this->token;
        $this->validator = new Validator($token, $timeShift);
        return $this->validator;
    }
    
    /**
     * Build a token and validate it
     * @throws ValidatorException
     */
    public function buildToken(Builder $builder = null): Token
    {
        $builder ??= $this->builder;
        $this->token = $builder->getToken();
        return $this->token;
    }
    
    /**
     * Parse a jwt token and return the Token object
     */
    public function parseToken(string $token): Token
    {
        $this->token = $this->parser()->parse($token);
        return $this->token;
    }
    
    /**
     * Validate the token
     * @throws ValidatorException
     */
    public function validateToken(Token $token = null, int $timeShift = 0, array $options = [], AbstractSigner $signer = null): void
    {
        $token ??= $this->token;
        $signer ??= $this->signer;
        $now = new \DateTimeImmutable();
        $options['expiration'] ??= $now->getTimestamp();
        $options['notBefore'] ??= $now->modify('-10 second')->getTimestamp();
        $options['issuedAt'] ??= $now->modify('+10 second')->getTimestamp();
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
     */
    public function getDefaultOptions(array $options = []): array
    {
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
