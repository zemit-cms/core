<?php

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
    
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function (?string $cipher = null, ?bool $useSigning = null) use ($di) {
            
            $config = $di->get('config');
            assert($config instanceof ConfigInterface);
            $options = $config->pathToArray('crypt', []);
            
            $cipher ??= $options['cipher'] ?? 'aes-256-cfb';
            $useSigning ??= $options['useSigning'] ?? true;
            
            $hash = $options['hash'] ?? 'sha256';
            $key = $options['key'] ?? 'T4\xb1\x8d\xa9\x98\x05\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3';
            $paddingScheme = $options['paddingScheme'] ?? Crypt::PADDING_DEFAULT;
            $padFactoryClass = $options['padFactory'] ?? \Phalcon\Encryption\Crypt\PadFactory::class;
            $authData = $options['authData'] ?? '';
            $authTag = $options['authTag'] ?? '';
            $authTagLength = $options['authTagLength'] ?? 16;
            
            $padFactory = new $padFactoryClass();
            assert($padFactory instanceof \Phalcon\Encryption\Crypt\PadFactory);
            
            $crypt = new Crypt($cipher, $useSigning, $padFactory);
            $crypt->setHashAlgorithm($hash);
            $crypt->setPadding($paddingScheme);
            $crypt->setKey($key);
            $crypt->setAuthData($authData);
            $crypt->setAuthTag($authTag);
            $crypt->setAuthTagLength($authTagLength);
            
            return $crypt;
        });
    }
}
