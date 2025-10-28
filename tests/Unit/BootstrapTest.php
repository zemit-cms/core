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

use Phalcon\Application\AbstractApplication;
use Phalcon\Di\DiInterface;
use Phalcon\Mvc\RouterInterface as MvcRouterInterface;
use Zemit\Bootstrap;
use Zemit\Config\ConfigInterface;
use Zemit\Bootstrap\Config;
use Zemit\Mvc\Router as MvcRouter;
use Zemit\Cli\Router as CliRouter;

/**
 * Class BootstrapTest
 * @package Tests\Unit
 */
class BootstrapTest extends AbstractUnit
{
    protected function setUp(): void
    {
    }
    
    /**
     * Testing the bootstrap service
     */
    public function testMvcBootstrap(): void
    {
        $bootstrap = new Bootstrap(Bootstrap::MODE_MVC);
        $this->assertInstanceOf(Bootstrap::class, $bootstrap);
        $this->assertInstanceOf(DiInterface::class, $bootstrap->di);
        $this->assertInstanceOf(DiInterface::class, $bootstrap->getDI());
        $this->assertInstanceOf(ConfigInterface::class, $bootstrap->config);
        $this->assertInstanceOf(ConfigInterface::class, $bootstrap->getConfig());
        $this->assertEquals(Bootstrap::MODE_MVC, $bootstrap->getMode());
        
        $this->assertEquals(Bootstrap::MODE_MVC, 'mvc');
        $this->assertEquals(Bootstrap::MODE_CLI, 'cli');
        $this->assertEquals(Bootstrap::MODE_WS, 'ws');
        
        $this->assertEquals(false, $bootstrap->isCli());
        $this->assertEquals(true, $bootstrap->isMvc());
        $this->assertEquals(false, $bootstrap->isWs());
        
        $bootstrap->setConfig(new Config());
        $this->assertInstanceOf(ConfigInterface::class, $bootstrap->getConfig());
        
        $bootstrap->setMode(Bootstrap::MODE_CLI);
        $this->assertEquals(Bootstrap::MODE_CLI, $bootstrap->getMode());
        
        $this->assertEquals(true, $bootstrap->isCli());
        $this->assertEquals(false, $bootstrap->isMvc());
        $this->assertEquals(false, $bootstrap->isWs());
        
        $bootstrap->setMode(Bootstrap::MODE_WS);
        $this->assertEquals(Bootstrap::MODE_WS, $bootstrap->getMode());
        
        $this->assertEquals(false, $bootstrap->isCli());
        $this->assertEquals(false, $bootstrap->isMvc());
        $this->assertEquals(true, $bootstrap->isWs());
        
        $this->assertTrue($bootstrap->di->has('bootstrap'));
        $this->assertTrue($bootstrap->di->has('config'));
        $this->assertTrue($bootstrap->di->has('application'));
        $this->assertTrue($bootstrap->di->has('router'));
        
        $this->assertInstanceOf(Bootstrap::class, $bootstrap->di->get('bootstrap'));
        $this->assertInstanceOf(ConfigInterface::class, $bootstrap->di->get('config'));
        $this->assertInstanceOf(AbstractApplication::class, $bootstrap->di->get('application'));
        $this->assertInstanceOf(MvcRouterInterface::class, $bootstrap->di->get('router'));
        $this->assertInstanceOf(MvcRouter::class, $bootstrap->di->get('router'));
    }
    
    public function testCliBootstrap(): void
    {
        $bootstrap = new Bootstrap(Bootstrap::MODE_CLI);
        $this->assertInstanceOf(Bootstrap::class, $bootstrap);
        $this->assertInstanceOf(DiInterface::class, $bootstrap->di);
        $this->assertInstanceOf(DiInterface::class, $bootstrap->getDI());
        $this->assertInstanceOf(ConfigInterface::class, $bootstrap->config);
        $this->assertInstanceOf(ConfigInterface::class, $bootstrap->getConfig());
    
        $this->assertEquals(true, $bootstrap->isCli());
        $this->assertEquals(false, $bootstrap->isMvc());
        $this->assertEquals(false, $bootstrap->isWs());
    
        $this->assertTrue($bootstrap->di->has('bootstrap'));
        $this->assertTrue($bootstrap->di->has('config'));
        $this->assertTrue($bootstrap->di->has('console'));
        $this->assertTrue($bootstrap->di->has('router'));
    
        $this->assertInstanceOf(Bootstrap::class, $bootstrap->di->get('bootstrap'));
        $this->assertInstanceOf(ConfigInterface::class, $bootstrap->di->get('config'));
        $this->assertInstanceOf(AbstractApplication::class, $bootstrap->di->get('console'));
//        $this->assertInstanceOf(CliRouterInterface::class, $bootstrap->di->get('router')); // phalcon bug
        $this->assertInstanceOf(CliRouter::class, $bootstrap->di->get('router'));
    }
    
    public function testBootstrapArgs(): void
    {
        $bootstrap = new Bootstrap(Bootstrap::MODE_CLI);
        
        $_SERVER['argv'] = [
            './zemit',
            'module',
            'task',
        ];
        
        $args = $bootstrap->getArgs();
        $this->assertIsArray($args);
        $this->assertEquals('module', $args['module']);
        $this->assertEquals('task', $args['task']);
        
        $_SERVER['argv'] = [
            './zemit',
            'module',
            'task',
            'action',
        ];
        $args = $bootstrap->getArgs();
        $this->assertIsArray($args);
        $this->assertEquals('module', $args['module']);
        $this->assertEquals('task', $args['task']);
        $this->assertEquals('action', $args['action']);
    }
}
