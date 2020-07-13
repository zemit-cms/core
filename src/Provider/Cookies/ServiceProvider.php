<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Cookies;

use Phalcon\Di\DiInterface;
use Phalcon\Http\Response\Cookies;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Zemit\Provider\Filter\ServiceProvider
 *
 * @package Zemit\Provider\Cookies
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * Use encryption by default
     */
    const DEFAULT_USE_ENCRYPTION = true;
    
    /**
     * No sign key by default
     */
    const DEFAULT_SIGN_KEY = '';
    
    /**
     * @var string Service name
     */
    protected $serviceName = 'cookies';
    
    /**
     * {@inheritdoc}
     *
     * @param DiInterface $di
     */
    public function register(\Phalcon\Di\DiInterface $di): void
    {
        $di->setShared($this->getName(), function () use ($di) {
            $config = $di->get('config')->cookies;
            $cookies = new Cookies(
                $config->useEncryption ?? self::DEFAULT_USE_ENCRYPTION,
                $config->signKey ?? self::DEFAULT_SIGN_KEY
            );
            return $cookies;
        });
    }
}
