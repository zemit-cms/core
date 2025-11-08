<?php

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit Team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PhalconKit\Tests\Unit\Di;

use PhalconKit\Tests\Unit\AbstractUnit;

class InjectableTest extends AbstractUnit
{
    public \PhalconKit\Di\Injectable $injectable;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->injectable = new \PhalconKit\Di\Injectable();
        $this->injectable->setDI($this->di);
    }
    
    public function testInjectable(): void
    {
        $this->assertInstanceOf(\Phalcon\Di\DiInterface::class, $this->injectable->__get('di'));
        $this->assertInstanceOf(\Phalcon\Di\DiInterface::class, $this->injectable->getDI());
        $this->assertInstanceOf(\Phalcon\Di\DiInterface::class, $this->injectable->di);
        
        $this->assertSame($this->di, $this->injectable->__get('di'));
        $this->assertSame($this->di, $this->injectable->getDI());
        $this->assertSame($this->di, $this->injectable->di);
        
        $this->assertTrue(isset($this->injectable->di));
        $this->assertFalse(isset($this->injectable->nonExistingProperty));
    }
}
