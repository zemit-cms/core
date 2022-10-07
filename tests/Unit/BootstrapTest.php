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

use Docopt;
use Dotenv\Dotenv;
use Phalcon\Di;
use Zemit\Bootstrap;
use Zemit\Bootstrap\Config;
use Zemit\Bootstrap\Modules;
use Zemit\Bootstrap\Prepare;
use Zemit\Bootstrap\Services;
use Zemit\Mvc\Application;
use Zemit\Support\Debug;

/**
 * Class BootstrapTest
 * @package Tests\Unit
 */
class BootstrapTest extends AbstractUnitTest
{
    /**
     * Testing the bootstrap service
     */
    public function testBootstrap() {
        $this->assertNotEmpty($this->bootstrap);
        $this->assertInstanceOf(Bootstrap::class, $this->bootstrap);
        
        $this->assertIsString($this->bootstrap->getMode());
        $this->assertEquals(Bootstrap::MODE_DEFAULT, $this->bootstrap->getMode());
        $this->assertFalse($this->bootstrap->isConsole());
        $this->assertIsArray($this->bootstrap->getArguments());
        
        // Bootstrap default services
        $this->assertInstanceOf(Di::class, $this->bootstrap->di);
        $this->assertInstanceOf(Services::class, $this->bootstrap->services);
        $this->assertInstanceOf(Config::class, $this->bootstrap->config);
        $this->assertInstanceOf(Application::class, $this->bootstrap->application);
        $this->assertInstanceOf(Modules::class, $this->bootstrap->modules);
        $this->assertInstanceOf(Prepare::class, $this->bootstrap->prepare);
        $this->assertInstanceOf(Docopt::class, $this->bootstrap->docopt);
        $this->assertInstanceOf(Dotenv::class, $this->bootstrap->dotenv);
        $this->assertInstanceOf(Debug::class, $this->bootstrap->debug);
    }
    
}
