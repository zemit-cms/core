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

namespace Zemit\Tests\Unit\Cli;

use Zemit\Bootstrap;
use Zemit\Cli\Router;
use Zemit\Tests\Unit\AbstractUnit;

class RouterTest extends AbstractUnit
{
    public \Zemit\Cli\Router $router;
    
    protected string $mode = Bootstrap::MODE_CLI;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->router = $this->di->get('router');
    }
    
    public function testRouterFromDi(): void
    {
        $this->assertInstanceOf(\Zemit\Router\RouterInterface::class, $this->router);
//        $this->assertInstanceOf(\Phalcon\Cli\RouterInterface::class, $this->router); // this interface is not used - https://github.com/phalcon/cphalcon/issues/16551
        $this->assertInstanceOf(\Phalcon\Cli\Router::class, $this->router);
        $this->assertInstanceOf(\Zemit\Cli\Router::class, $this->router);
    }
    
    public function testToArray(): void
    {
        $routerToArray = $this->router->toArray();
        $this->assertIsArray($routerToArray);
        $this->assertIsString($routerToArray['module']);
        $this->assertIsString($routerToArray['action']);
        $this->assertIsArray($routerToArray['params']);
        $this->assertIsArray($routerToArray['matches']);
        $this->assertNull($routerToArray['matched']);
    }
    
    public function testRealScenario(): void
    {
        $this->router->handle([
            'module' => 'cli',
            'task' => 'error',
            'action' => 'not-found',
            'params' => ['test' => 'test'],
        ]);
        $this->assertEquals('cli', $this->router->getModuleName());
        $this->assertEquals('error', $this->router->getTaskName());
        $this->assertEquals('not-found', $this->router->getActionName());
        $this->assertEquals(['test' => 'test'], $this->router->getParams());
    }
}
