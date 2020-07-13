<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Oauth2Google;

use League\OAuth2\Client\Provider\Google;
use Phalcon\Di\DiInterface;

use Zemit\Provider\AbstractServiceProvider;

/**
 * Zemit\Provider\Tag\ServiceProvider
 * @see https://github.com/tegaphilip/padlock
 * @see https://oauth2.thephpleague.com/framework-integrations/
 *
 * @package Zemit\Provider\Config
 */
class ServiceProvider extends AbstractServiceProvider
{
    protected $serviceName = 'oauth2Google';
    
    /**
     * {@inheritdoc}
     *
     * @param DiInterface $di
     */
    public function register(DiInterface $di): void
    {
        $config = $di->get('config');
        $session = $di->get('session');
        $di->setShared($this->getName(), function () use ($config, $session) {
            $google = new Google($config->oauth2->google->toArray());
            return $google;
        });
    }
}
