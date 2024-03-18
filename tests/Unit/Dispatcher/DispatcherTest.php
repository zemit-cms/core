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

namespace Unit\Dispatcher;

use Zemit\Bootstrap;
use Zemit\Dispatcher\AbstractDispatcher;
use Zemit\Dispatcher\DispatcherInterface;
use Zemit\Tests\Unit\AbstractUnit;

class DispatcherTest extends AbstractUnit
{
    protected string $mode = Bootstrap::MODE_CLI;
    
    protected DispatcherInterface $dispatcher;
    protected \Phalcon\Mvc\DispatcherInterface $mvcDispatcher;
    protected \Phalcon\Cli\DispatcherInterface $cliDispatcher;
    
    protected function setUp(): void
    {
        $this->dispatcher = new AbstractDispatcher();
        $this->mvcDispatcher = new \Zemit\Mvc\Dispatcher();
        $this->cliDispatcher = new \Zemit\Cli\Dispatcher();
    }
    
    public function testDispatcherInstance(): void
    {
        // Abstract
        $this->assertInstanceOf(\Zemit\Dispatcher\AbstractDispatcher::class, $this->dispatcher);
        $this->assertInstanceOf(\Zemit\Dispatcher\DispatcherInterface::class, $this->dispatcher);
        
        $this->assertInstanceOf(\Phalcon\Dispatcher\AbstractDispatcher::class, $this->dispatcher);
        $this->assertInstanceOf(\Phalcon\Dispatcher\DispatcherInterface::class, $this->dispatcher);
        
        // MVC
        $this->assertInstanceOf(\Zemit\Mvc\Dispatcher::class, $this->mvcDispatcher);
        $this->assertInstanceOf(\Zemit\Dispatcher\DispatcherInterface::class, $this->mvcDispatcher);
        
        $this->assertInstanceOf(\Phalcon\Dispatcher\AbstractDispatcher::class, $this->mvcDispatcher);
        $this->assertInstanceOf(\Phalcon\Dispatcher\DispatcherInterface::class, $this->mvcDispatcher);
        $this->assertInstanceOf(\Phalcon\Mvc\DispatcherInterface::class, $this->mvcDispatcher);
        
        // CLI
        $this->assertInstanceOf(\Zemit\Cli\Dispatcher::class, $this->cliDispatcher);
        $this->assertInstanceOf(\Zemit\Dispatcher\DispatcherInterface::class, $this->cliDispatcher);
        
        $this->assertInstanceOf(\Phalcon\Dispatcher\AbstractDispatcher::class, $this->cliDispatcher);
        $this->assertInstanceOf(\Phalcon\Dispatcher\DispatcherInterface::class, $this->cliDispatcher);
        $this->assertInstanceOf(\Phalcon\Cli\DispatcherInterface::class, $this->cliDispatcher);
    }
    
    public function testCallActionMethod(): void
    {
        $handler = new class {
            public function actionMethod(int $param1 = 1, int $param2 = 1): int
            {
                return $param1 + $param2;
            }
        };
        
        $params = ['param1' => 'string_value', 0 => 1, 'param2' => 2, 1 => 3];
        $result = $this->dispatcher->callActionMethod($handler, 'actionMethod', $params);
        $this->assertEquals(4, $result, 'callActionMethod did not return expected result');
        
        $result = $this->dispatcher->callActionMethod($handler, 'actionMethod', []);
        $this->assertEquals(2, $result, 'callActionMethod did not return expected result');
        
        $result = $this->dispatcher->callActionMethod($handler, 'actionMethod', ['test' => 2, 'test2' => 2]);
        $this->assertEquals(2, $result, 'callActionMethod did not return expected result');
    }
    
    public function testForward(): void
    {
        $this->dispatcher->forward(['action' => 'notFound'], false);
        $this->assertSame('notFound', $this->dispatcher->getActionName());
        
        $this->dispatcher->forward(['action' => 'notFound'], true);
        $this->assertSame('notFound', $this->dispatcher->getActionName());
        
        $this->dispatcher->forward(['action' => 'non-existing-action'], true);
        $this->assertSame('non-existing-action', $this->dispatcher->getActionName());
        
        $this->dispatcher->forward(['action' => 'non-existing-action'], false);
        $this->assertSame('non-existing-action', $this->dispatcher->getActionName());
    }
    
    public function testCanForward(): void
    {
        // Test Abstract Dispatcher
        $this->assertFalse($this->dispatcher->canForward([]));
        $this->assertFalse($this->dispatcher->canForward(['module' => '']));
        $this->assertTrue($this->dispatcher->canForward(['module' => 'test']));
        
        // With same values
        $forward = ['namespace' => 'namespace', 'module' => 'module', 'action' => 'action', 'params' => ['param' => true]];
        $this->dispatcher->setNamespaceName('namespace');
        $this->dispatcher->setModuleName('module');
        $this->dispatcher->setActionName('action');
        $this->dispatcher->setParams(['param' => true]);
        $this->assertFalse($this->dispatcher->canForward($forward));
        
        // Test MVC Dispatcher
        $this->assertFalse($this->mvcDispatcher->canForward([]));
        $this->assertFalse($this->mvcDispatcher->canForward(['controller' => '']));
        $this->assertTrue($this->mvcDispatcher->canForward(['controller' => 'new']));
        $this->assertFalse($this->mvcDispatcher->canForward(['task' => 'new']));
        
        // Test CLI Dispatcher
        $this->assertFalse($this->cliDispatcher->canForward([]));
        $this->assertFalse($this->cliDispatcher->canForward(['task' => '']));
        $this->assertTrue($this->cliDispatcher->canForward(['task' => 'new']));
        $this->assertFalse($this->cliDispatcher->canForward(['controller' => 'new']));
    }
    
    public function testUnsetForwardNullParts(): void
    {
        // Forward attributes with nonexistent parts
        $forwardWithNullParts = [
            'namespace' => 'Custom\Namespace',
            'module' => null,
            'task' => 'CustomTask',
            'controller' => null,
            'action' => 'actionName',
            'params' => ['param1', 'param2'],
        ];
        
        // Expected result after unsetting NULL parts
        $expectedForward = [
            'namespace' => 'Custom\Namespace',
            'task' => 'CustomTask',
            'action' => 'actionName',
            'params' => ['param1', 'param2'],
        ];
        
        $result = $this->dispatcher->unsetForwardNullParts($forwardWithNullParts);
        $this->assertSame($expectedForward, $result, "unsetForwardNullParts() does not unset NULL parts correctly!");
        
        // Try with all null parts
        $forwardWithNullParts = [
            'namespace' => null,
            'module' => null,
            'task' => null,
            'controller' => null,
            'action' => null,
            'params' => null,
        ];
        
        $result = $this->dispatcher->unsetForwardNullParts($forwardWithNullParts);
        $this->assertEquals([], $result, "unsetForwardNullParts() does not unset NULL parts correctly!");
        
        // Try with no null parts
        $forwardWithoutNullParts = [
            'namespace' => 'Custom\Namespace',
            'module' => 'Cli',
            'task' => 'CustomTask',
            'action' => 'actionName',
            'params' => ['param1', 'param2'],
        ];
        
        $result = $this->dispatcher->unsetForwardNullParts($forwardWithoutNullParts);
        $this->assertEquals($forwardWithoutNullParts, $result, "unsetForwardNullParts() does not keep parts correctly!");
    }
    
    public function testToArray(): void
    {
        $dispatcherArray = $this->dispatcher->toArray();
        $this->assertIsString($dispatcherArray['namespace']);
        $this->assertEquals('', $dispatcherArray['namespace']);
        $this->assertIsString($dispatcherArray['module']);
        $this->assertEquals('', $dispatcherArray['module']);
        $this->assertIsString($dispatcherArray['action']);
        $this->assertEquals('', $dispatcherArray['action']);
        $this->assertIsArray($dispatcherArray['params']);
        $this->assertEquals([], $dispatcherArray['params']);
        $this->assertIsString($dispatcherArray['handlerClass']);
        $this->assertEquals('', $dispatcherArray['handlerClass']);
        $this->assertIsString($dispatcherArray['handlerSuffix']);
        $this->assertEquals('', $dispatcherArray['handlerSuffix']);
        $this->assertIsString($dispatcherArray['activeMethod']);
        $this->assertEquals('Action', $dispatcherArray['activeMethod']);
        $this->assertIsString($dispatcherArray['actionSuffix']);
        $this->assertEquals('Action', $dispatcherArray['actionSuffix']);
        
        $mvcArray = $this->mvcDispatcher->toArray();
        $this->assertIsString($mvcArray['controller']);
        $this->assertEquals('index', $mvcArray['controller']);
        $this->assertIsString($mvcArray['previousNamespace']);
        $this->assertEquals('', $mvcArray['previousNamespace']);
        $this->assertIsString($mvcArray['previousController']);
        $this->assertEquals('', $mvcArray['previousController']);
        $this->assertIsString($mvcArray['previousAction']);
        $this->assertEquals('', $mvcArray['previousAction']);
        
        $cliArray = $this->cliDispatcher->toArray();
        $this->assertIsString($cliArray['task']);
        $this->assertEquals('main', $cliArray['task']);
        $this->assertIsString($cliArray['taskSuffix']);
        $this->assertEquals('Task', $cliArray['taskSuffix']);
    }
}
