<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit;

use Phalcon\Di\InjectionAwareInterface;

/**
 * Phosphorum\Provider\ServiceProviderInterface
 *
 * @package Phosphorum\Provider
 */
interface ServiceProviderInterface extends InjectionAwareInterface
{
    /**
     * Register application service.
     *
     * @return void
     */
    public function register();
    
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
