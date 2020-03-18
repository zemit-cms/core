<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Filter;

use Phalcon\Di\DiInterface;
use Zemit\Filter;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Zemit\Provider\Filter\ServiceProvider
 *
 * @package Zemit\Provider\Config
 */
class ServiceProvider extends AbstractServiceProvider
{
    protected $serviceName = 'filter';
    
    /**
     * {@inheritdoc}
     *
     * @param DiInterface $di
     */
    public function register(\Phalcon\Di\DiInterface $di): void
    {
        $di->setShared($this->getName(), function() use ($di) {
            $filter = new Filter();
            
            return $filter;
        });
    }
}
