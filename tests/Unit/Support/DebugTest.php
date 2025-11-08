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

namespace PhalconKit\Tests\Unit\Support;

use PhalconKit\Support\Debug;
use PhalconKit\Support\Version as PhalconKitVersion;
use Phalcon\Support\Version as PhalconVersion;
use PhalconKit\Tests\Unit\AbstractUnit;

/**
 * Class VersionTest
 * @package Tests\Unit
 */
class DebugTest extends AbstractUnit
{
    public Debug $debug;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->debug = $this->di->get('debug');
    }
    
    public function testDebugFromDi(): void
    {
        $this->assertInstanceOf(Debug::class, $this->debug);
        $this->testGetVersion($this->debug);
    }
    
    public function testGetVersion(?Debug $debug = null): void
    {
        $debug ??= new Debug();
        
        $result = $debug->getVersion();
        
        $phalconKitVersion = new PhalconKitVersion();
        $phalconVersion = new PhalconVersion();
        
        $this->assertStringContainsString($phalconKitVersion->get(), $result);
        $this->assertStringContainsString($phalconVersion->get(), $result);
        $this->assertStringContainsString('Phalcon Kit', $result);
        $this->assertStringContainsString('Phalcon Framework', $result);
    }
}
