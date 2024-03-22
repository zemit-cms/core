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

use LogicException;
use Phalcon\Di\DiInterface;
use Zemit\Di\Injectable;

/**
 * Class AbstractServiceProvider
 */
abstract class AbstractServiceProvider extends Injectable implements ServiceProviderInterface
{
    /**
     * The Service name.
     */
    protected string $serviceName;
    
    /**
     * Set DI and run configure();
     */
    public function __construct(DiInterface $di)
    {
        if (empty($this->serviceName)) {
            throw new LogicException(sprintf('The service provider defined in "%s" cannot have an empty name.', get_class($this)));
        }
        $this->setDI($di);
        $this->configure();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return $this->serviceName;
    }
    
    /**
     * {@inheritdoc}
     */
    public function boot(): void
    {
    }
    
    /**
     * {@inheritdoc}
     */
    public function configure(): void
    {
    }
}
