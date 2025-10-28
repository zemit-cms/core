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

namespace Zemit\Tests\Unit\Support;

use Zemit\Support\Debug;
use Zemit\Support\Version as ZemitVersion;
use Phalcon\Support\Version as PhalconVersion;
use Zemit\Tests\Unit\AbstractUnit;

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
        
        $zemitVersion = new ZemitVersion();
        $phalconVersion = new PhalconVersion();
        
        $this->assertStringContainsString($zemitVersion->get(), $result);
        $this->assertStringContainsString($phalconVersion->get(), $result);
        $this->assertStringContainsString('Zemit Core', $result);
        $this->assertStringContainsString('Phalcon Framework', $result);
    }
}
