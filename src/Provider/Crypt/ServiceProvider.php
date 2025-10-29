<?php

declare(strict_types=1);

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Crypt;

use Phalcon\Di\DiInterface;
use Phalcon\Encryption\Crypt;
use Zemit\Config\ConfigInterface;
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'crypt';
    
    #[\Override]
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function (?string $cipher = null, ?bool $useSigning = null) use ($di) {
            
            $config = $di->get('config');
            assert($config instanceof ConfigInterface);
            $options = $config->pathToArray('crypt') ?? [];
            
            $cipher ??= $options['cipher'] ?? 'aes-256-gcm';
            $useSigning ??= $options['useSigning'] ?? true;
            $hash = $options['hashAlgorithm'] ?? 'sha256';
            $key = $options['key'] ?? ($_ENV['APP_CRYPT_KEY'] ?? null);
            $padScheme = $options['padScheme'] ?? Crypt::PADDING_DEFAULT;
            $padFactoryClass = $options['padFactory'] ?? Crypt\PadFactory::class;
            
            $authData = $options['authData'] ?? '';
            $authTag = $options['authTag'] ?? '';
            $authTagLength = $options['authTagLength'] ?? 16;
            
            $padFactory = new $padFactoryClass();
            assert($padFactory instanceof Crypt\PadFactory);
            
            // -----------------------------------------------------------------
            // Validate key
            // -----------------------------------------------------------------
            if (empty($key) || strlen($key) < 32) {
                throw new \RuntimeException('Invalid encryption key: must be at least 32 bytes for AES-256 ciphers.');
            }
            
            // -----------------------------------------------------------------
            // Validate cipher existence
            // -----------------------------------------------------------------
            $availableCiphers = openssl_get_cipher_methods(true);
            if (!in_array(strtolower($cipher), $availableCiphers, true)) {
                throw new \RuntimeException(sprintf(
                    'Invalid cipher "%s": not supported by the current OpenSSL build.',
                    $cipher
                ));
            }
            
            // -----------------------------------------------------------------
            // Validate cipher mode vs signing
            // -----------------------------------------------------------------
            $lowerCipher = strtolower($cipher);
            
            $isAEAD = str_ends_with($lowerCipher, '-gcm') || str_ends_with($lowerCipher, '-ccm');
            $isStreamMode = str_ends_with($lowerCipher, '-cfb')
                || str_ends_with($lowerCipher, '-ofb')
                || str_ends_with($lowerCipher, '-ctr');
            
            // AEAD handles authentication internally
            if ($isAEAD && $useSigning) {
                throw new \RuntimeException(sprintf(
                    'Invalid configuration: cipher "%s" is AEAD (auth built-in). Disable "useSigning".',
                    $cipher
                ));
            }
            
            // Stream modes cannot be safely signed via Phalcon’s HMAC path
            if ($isStreamMode && $useSigning) {
                throw new \RuntimeException(sprintf(
                    'Invalid configuration: cipher "%s" does not support signing (stream mode). Disable "useSigning" or use CBC/GCM instead.',
                    $cipher
                ));
            }
            
            // -----------------------------------------------------------------
            // Build Crypt instance
            // -----------------------------------------------------------------
            $crypt = new Crypt($cipher, $useSigning, $padFactory);
            $crypt->setKey($key);
            $crypt->setPadding($padScheme);
            
            if ($useSigning) {
                $crypt->setHashAlgorithm($hash);
            }
            
            $crypt->setAuthData($authData);
            $crypt->setAuthTag($authTag);
            $crypt->setAuthTagLength($authTagLength);
            
            return $crypt;
        });
    }
}
