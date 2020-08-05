<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider;

/**
 * Interface ServiceProviderInterface
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Provider
 */
interface ServiceProviderInterface extends \Phalcon\Di\ServiceProviderInterface, \Phalcon\Di\InjectionAwareInterface
{
    /**
     * Register application service.
     *
     * @return void
     */
    public function register(\Phalcon\Di\DiInterface $di) : void;
    
    /**
     * Package boot method.
     *
     * @return void
     */
    public function boot();
    
    /**
     * Configures the current service provider.
     *
     * @return void
     */
    public function configure();
    
    /**
     * Get the Service name.
     *
     * @return string
     */
    public function getName();
}
