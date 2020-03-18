<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\V8js;

use Phalcon\Di\DiInterface;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Zemit\Provider\JavascriptParser\ServiceProvider
 *
 * @package Zemit\Provider\JavascriptParser
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'v8js';
    
    /**
     * {@inheritdoc}
     *
     * @param DiInterface $di
     */
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function() {
            $v8 = new \V8Js();
            
            return $v8;
        });
    }
}
