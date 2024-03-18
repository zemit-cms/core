<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Unit\Di;

use Phalcon\Di\DiInterface;
use Phalcon\Di\InjectionAwareInterface;
use Phalcon\Flash\Session;
use Zemit\Bootstrap;
use Zemit\Di\InjectableTrait;
use Zemit\Tests\Unit\AbstractUnit;

class InjectableTraitTest extends AbstractUnit
{
    public $injectable;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->injectable = new class extends \stdClass implements InjectionAwareInterface {
            use InjectableTrait;
        };
    }
    
    public function testInjectableTrait(): void
    {
        $this->assertInstanceOf(\Phalcon\Di\DiInterface::class, $this->injectable->__get('di'));
        $this->assertInstanceOf(\Phalcon\Di\DiInterface::class, $this->injectable->getDI());
        $this->assertInstanceOf(\Phalcon\Di\DiInterface::class, $this->injectable->di);
        
        $this->assertSame($this->di, $this->injectable->__get('di'));
        $this->assertSame($this->di, $this->injectable->getDI());
        $this->assertSame($this->di, $this->injectable->di);
        
        $this->assertTrue(isset($this->injectable->di));
        $this->assertFalse(isset($this->injectable->nonExistingProperty));
        
        // bootstrap should be defined
        $this->assertInstanceOf(Bootstrap::class, $this->injectable->bootstrap);
        
        // unset sessionBag and persistent should trigger an exception
        $this->expectException(\Phalcon\Di\Exception::class);
        $this->assertNull($this->injectable->persistent);
        
        // unset unknown should trigger an exception
        $this->expectException(\Phalcon\Di\Exception::class);
        $this->assertNull($this->injectable->nonExistingProperty);
        
        // persistent should return sessionBag
        $this->di->set('sessionBag', new Session());
        $this->assertInstanceOf(Session::class, $this->injectable->persistent);
    }
}
