<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\ReCaptcha;

use Phalcon\Di\DiInterface;
use Zemit\Config\ConfigInterface;
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'reCaptcha';
    
    #[\Override]
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function () use ($di) {
            
            $config = $di->get('config');
            assert($config instanceof ConfigInterface);
            
            $options = $config->pathToArray('reCaptcha', []);
            
            $secret = $options['secret'] ?? null;
            $requestMethod = $options['requestMethod'] ?? null;
            
            $reCaptcha = new \ReCaptcha\ReCaptcha($secret ?: '', $requestMethod);
            $reCaptcha->setExpectedHostname($options['expectedHostname'] ?? '');
            $reCaptcha->setExpectedApkPackageName($options['expectedApkPackageName'] ?? '');
            $reCaptcha->setExpectedAction($options['expectedAction'] ?? '');
            $reCaptcha->setScoreThreshold($options['scoreThreshold'] ?? 0.5);
            
            return $reCaptcha;
        });
    }
}
