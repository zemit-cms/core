<?php

namespace Zemit\Provider\Jwt;

use Phalcon\Encryption\Security\JWT\Builder;
use Phalcon\Encryption\Security\JWT\Exceptions\ValidatorException;
use Phalcon\Encryption\Security\JWT\Signer\Hmac;
use Phalcon\Encryption\Security\JWT\Token\Parser;
use Phalcon\Encryption\Security\JWT\Signer\AbstractSigner;
use Phalcon\Encryption\Security\JWT\Token\Token;
use Phalcon\Encryption\Security\JWT\Validator;

/**
 * Issue, parse and validate JSON Web Tokens (JWT) as described in RFC 7519.
 *
 * Builder (Phalcon\Encryption\Security\JWT\Builder)
 * Parser (Phalcon\Encryption\Security\JWT\Token\Parser)
 * Validator (Phalcon\Encryption\Security\JWT\Validator)
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
    public function signer(?string $signer = null, ?string $algo = null): AbstractSigner
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
    public function validator(?Token $token = null, int $timeShift = 0): Validator
    {
        $token ??= $this->token;
        $this->validator = new Validator($token, $timeShift);
        return $this->validator;
    }
    
    /**
     * Build a token and validate it
     * @throws ValidatorException
     */
    public function buildToken(?Builder $builder = null): Token
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
        // fix phalcon error
        // https://github.com/phalcon/cphalcon/blob/bf9b70cee49afcccd10cfee783218ead2419d8ef/phalcon/Encryption/Security/JWT/Token/Parser.zep#L166
        // https://github.com/phalcon/cphalcon/issues/15608#issuecomment-1359323119
        json_encode(null);
        $this->token = $this->parser()->parse($token);
        return $this->token;
    }
    
    /**
     * Validate the token
     * @throws ValidatorException
     */
    public function validateToken(?Token $token = null, int $timeShift = 0, array $options = [], ?AbstractSigner $signer = null): void
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
        $now = new \DateTimeImmutable();
        $options['expiration'] ??= $this->options['expiration'] ?? $now->modify('+1 day')->getTimestamp();
        $options['notBefore'] ??= $this->options['notBefore'] ?? $now->modify('-1 minute')->getTimestamp();
        $options['issuedAt'] ??= $this->options['issuedAt'] ?? $now->modify('now')->getTimestamp();
        $options['issuer'] ??= $this->options['issuer'] ?? '';
        $options['audience'] ??= $this->options['audience'] ?? '';
        $options['contentType'] ??= $this->options['contentType'] ?? '';
        $options['passphrase'] ??= $this->options['passphrase'] ?? '';
        $options['id'] ??= $this->options['id'] ?? '';
        $options['subject'] ??= $this->options['subject'] ?? '';
        
        return $options;
    }
}
