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

namespace Tests\Unit;

use Zemit\Version;

/**
 * Class VersionTest
 * @package Tests\Unit
 */
class VersionTest extends AbstractUnitTest
{
    /**
     * Testing the version class
     */
    public function testVersion() {
        $this->assertNotEmpty($this->bootstrap->config->path('core.version'));
        $this->assertEquals($this->bootstrap->config->path('core.version'), Version::get());
        
        $this->assertNotEmpty(Version::getId());
        
        $this->assertIsInt(Version::getPart(Version::VERSION_MAJOR));
        $this->assertIsInt(Version::getPart(Version::VERSION_MEDIUM));
        $this->assertIsInt(Version::getPart(Version::VERSION_MINOR));
        $this->assertIsInt(Version::getPart(Version::VERSION_SPECIAL_NUMBER));
        $this->assertNotEmpty(Version::getPart(Version::VERSION_SPECIAL));
    }
}
