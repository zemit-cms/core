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

namespace Unit\Support;

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
    /**
     * @covers \Zemit\Support\Debug::getVersion
     */
    public function testGetVersion()
    {
        // Prepare
        $debug = new Debug();
        
        // Test
        $result = $debug->getVersion();
        
        $zemitVersion = new ZemitVersion();
        $phalconVersion = new PhalconVersion();
        
        // Assert
        $this->assertStringContainsString($zemitVersion->get(), $result);
        $this->assertStringContainsString($phalconVersion->get(), $result);
        $this->assertStringContainsString('Zemit Core', $result);
        $this->assertStringContainsString('Phalcon Framework', $result);
    }
}
