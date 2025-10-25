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

use Phalcon\Di\DiInterface;

/**
 * Interface ServiceProviderInterface
 */
interface ServiceProviderInterface extends \Phalcon\Di\ServiceProviderInterface, \Phalcon\Di\InjectionAwareInterface
{
    /**
     * Register application service.
     */
    #[\Override]
    public function register(DiInterface $di): void;
    
    /**
     * Package boot method.
     */
    public function boot(): void;
    
    /**
     * Configures the current service provider.
     */
    public function configure(): void;
    
    /**
     * Get the Service name.
     */
    public function getName(): string;
}
