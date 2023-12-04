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

namespace Zemit\Tests\Unit;

use Zemit\Support\Version as ZemitVersion;
use Phalcon\Support\Version as PhalconVersion;

/**
 * Class VersionTest
 * @package Tests\Unit
 */
class VersionTest extends AbstractUnit
{
    /**
     * Testing the version class
     */
    public function testVersion() {
        $version = new ZemitVersion();
        $phalconVersion = new PhalconVersion();
        
        // Config must match Zemit Core version
        $this->assertNotEmpty($this->bootstrap->config->path('core.version'));
        $this->assertEquals($this->bootstrap->config->path('core.version'), $version->get());
        
        // Config must match Phalcon Framework version
        $this->assertNotEmpty($this->bootstrap->config->path('phalcon.version'));
        $this->assertEquals($this->bootstrap->config->path('phalcon.version'), $phalconVersion->get());
        
        // Test version->get()
        $this->assertNotEmpty($version->get());
        $this->assertIsString($version->get());
        
        // Test version->getId()
        $this->assertNotEmpty($version->getId());
        $this->assertIsString($version->getId());
        
        // Test version->getPart()
        $this->assertIsString($version->getPart(PhalconVersion::VERSION_MAJOR));
        $this->assertIsString($version->getPart(PhalconVersion::VERSION_MEDIUM));
        $this->assertIsString($version->getPart(PhalconVersion::VERSION_MINOR));
        $this->assertIsString($version->getPart(PhalconVersion::VERSION_SPECIAL));
        $this->assertIsString($version->getPart(PhalconVersion::VERSION_SPECIAL_NUMBER));
        
        // Match version->get() with version->getPart()
        $specialNumber = $version->getPart(PhalconVersion::VERSION_SPECIAL_NUMBER);
        $this->assertEquals(
            $version->get(),
            $version->getPart(PhalconVersion::VERSION_MAJOR) . '.' .
            $version->getPart(PhalconVersion::VERSION_MEDIUM) . '.' .
            $version->getPart(PhalconVersion::VERSION_MINOR) .
            $version->getPart(PhalconVersion::VERSION_SPECIAL) .
            ($specialNumber ?: '')
        );
        
        $this->assertInstanceOf(PhalconVersion::class, $version);
    }
}
