<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Profiler;

use Phalcon\Di\DiInterface;
use Zemit\Db\Profiler;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Zemit\Provider\Tag\ServiceProvider
 *
 * @package Zemit\Provider\Config
 */
class ServiceProvider extends AbstractServiceProvider
{
    protected $serviceName = 'profiler';
    
    /**
     * {@inheritdoc}
     *
     * @param DiInterface $di
     */
    public function register(\Phalcon\Di\DiInterface $di) : void
    {
        $di->setShared($this->getName(), Profiler::class);
    }
}
