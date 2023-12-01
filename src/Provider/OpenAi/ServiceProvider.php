<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\OpenAi;

use Orhanerday\OpenAi\OpenAi;
use Phalcon\Di\DiInterface;
use Zemit\Bootstrap\Config;
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'openai';
    
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function () use ($di) {
            
            $config = $di->get('config');
            assert($config instanceof Config);
            $openAiConfig = $config->pathToArray('openai') ?? [];
            
            $openAi = new OpenAi($openAiConfig['secretKey'] ?? null);
            
            if (!empty($openAiConfig['organizationId'])) {
                $openAi->setORG($openAiConfig['organizationId']);
            }
            
            return $openAi;
        });
    }
}
