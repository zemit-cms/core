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
use Phalcon\Di\Injectable;

/**
 * Zemit\Provider\AbstractServiceProvider
 *
 * @package Zemit\Provider
 */
abstract class AbstractServiceProvider extends Injectable implements ServiceProviderInterface
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName;
    
    final public function __construct(DiInterface $di)
    {
        if (!$this->serviceName) {
            throw new LogicException(
                sprintf('The service provider defined in "%s" cannot have an empty name.', get_class($this))
            );
        }
        $this->setDI($di);
        $this->configure();
    }
    
    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getName()
    {
        return $this->serviceName;
    }
    
    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function boot()
    {
    }
    
    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function configure()
    {
    }
}
