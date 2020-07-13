<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Oauth2Facebook;

use League\OAuth2\Client\Provider\Facebook;
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
    protected $serviceName = 'oauth2Facebook';
    
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
            $facebook = new Facebook($config->oauth2->facebook->toArray());
            return $facebook;
        });
    }
}
