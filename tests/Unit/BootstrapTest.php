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

use Phalcon\Di;
use Zemit\Bootstrap;
use Zemit\Bootstrap\Modules;
use Zemit\Bootstrap\Services;
use Zemit\Bootstrap\Config;
use Zemit\Bootstrap\Prepare;
use Zemit\Cli\Console;
use Zemit\Debug;
use Zemit\Mvc\Application;
use Zemit\Mvc\Router as MvcRouter;
use Zemit\Cli\Router as CliRouter;
use Dotenv\Dotenv;
use Docopt;

/**
 * Class BootstrapTest
 * @package Tests\Unit
 */
class BootstrapTest extends AbstractUnit
{
    /**
     * Testing the bootstrap service
     */
    public function testBootstrap() {
        $this->assertNotEmpty($this->bootstrap);
        $this->assertInstanceOf(Bootstrap::class, $this->bootstrap);
        
        $this->assertIsString($this->bootstrap->getMode());
        $this->assertContainsEquals($this->bootstrap->getMode(), [
            Bootstrap::MODE_DEFAULT,
            Bootstrap::MODE_CONSOLE,
            Bootstrap::MODE_CLI,
        ]);
        $this->assertEquals(Bootstrap::MODE_DEFAULT, $this->bootstrap->getMode());
        $this->assertEquals(Bootstrap::MODE_CONSOLE, Bootstrap::MODE_CLI);
        $this->assertFalse($this->bootstrap->isConsole());
        $this->assertIsArray($this->bootstrap->getArguments());
        
        $this->assertInstanceOf(Dotenv::class, $this->bootstrap->dotenv);
        $this->assertInstanceOf(Docopt::class, $this->bootstrap->docopt);
        $this->assertInstanceOf(Di::class, $this->bootstrap->di);
        $this->assertInstanceOf(Prepare::class, $this->bootstrap->prepare);
        $this->assertInstanceOf(Config::class, $this->bootstrap->config);
        $this->assertInstanceOf(Debug::class, $this->bootstrap->debug);
        $this->assertInstanceOf(Services::class, $this->bootstrap->services);
        $this->assertInstanceOf(Modules::class, $this->bootstrap->modules);
        
        if ($this->bootstrap->getMode() === Bootstrap::MODE_DEFAULT) {
            $this->assertInstanceOf(Application::class, $this->bootstrap->application);
            $this->assertInstanceOf(MvcRouter::class, $this->bootstrap->router);
        }
        if ($this->bootstrap->getMode() === Bootstrap::MODE_CONSOLE) {
            $this->assertInstanceOf(Console::class, $this->bootstrap->application);
            $this->assertInstanceOf(CliRouter::class, $this->bootstrap->router);
        }
        
        $this->assertIsArray($this->bootstrap->providers);
        $this->assertNotEmpty($this->bootstrap->providers);
        
//        if ($this->mode === Bootstrap::MODE_DEFAULT) {
//            $this->mode = Bootstrap::MODE_CLI;
//            $this->tearDown();
//            $this->setUp();
//            $this->testBootstrap();
//        }
    }
}
