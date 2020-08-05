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
 * Class ServiceProvider
 *
 * @link https://github.com/tegaphilip/padlock
 * @link https://oauth2.thephpleague.com/framework-integrations/
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Provider\Oauth2Google
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
        $di->setShared($this->getName(), function() use ($config, $session) {
            $google = new Google($config->oauth2->google->toArray());
            
            return $google;
        });
    }
}
