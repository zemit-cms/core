<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace App\Provider\OpenAi;

use Orhanerday\OpenAi\OpenAi;
use Phalcon\Di\DiInterface;
use Zemit\Bootstrap\Config;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Zemit\Provider\OpenAi\ServiceProvider
 *
 * @package Zemit\Provider\OpenAi
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'openai';

    /**
     * {@inheritdoc}
     *
     * Register the Flash Service with the Twitter Bootstrap classes.
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function() use ($di) {
            /** @var Config $config */
            $config = $di->get('config');
            $openAiConfig = $config->path('openai');

            $openAi = new OpenAi($openAiConfig['secretKey']);
            if (!empty($openAiConfig['organizationId'])) {
                $openAi->setORG($openAiConfig['organizationId']);
            }
            
            return $openAi;
        });
    }
}
