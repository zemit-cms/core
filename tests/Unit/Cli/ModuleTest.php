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
use Zemit\Cli\Module;
use Zemit\Tests\Unit\AbstractUnit;

class ModuleTest extends AbstractUnit
{
    public \Zemit\Cli\Module $module;
    
    protected string $mode = Bootstrap::MODE_CLI;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->module = new Module();
    }
    
    public function testRegisterAutoloaders(): void
    {
        $this->module->registerAutoloaders($this->di);
        $this->assertIsArray($this->module->loader->getNamespaces());
        $this->assertNotEmpty($this->module->loader->getNamespaces());
        $this->assertTrue($this->module->loader->isRegistered());
    }
    
    public function testRegisterServices(): void
    {
        $this->module->registerServices($this->di);
        $this->assertEquals('Zemit\\Cli\\Tasks', $this->module->dispatcher->getDefaultNamespace());
        $this->assertEquals('Zemit\\Cli\\Tasks', $this->module->dispatcher->getNamespaceName());
    }
    
    public function testGetNamespaces(): void
    {
        $namespaces = $this->module->getNamespaces();
        $this->assertArrayHasKey('Zemit\\Cli\\Tasks', $namespaces);
        $this->assertArrayHasKey('Zemit\\Cli\\Models', $namespaces);
        $this->assertArrayHasKey('Zemit\\Models', $namespaces);
        
        $this->assertIsString($namespaces['Zemit\\Cli\\Tasks']);
        $this->assertIsString($namespaces['Zemit\\Cli\\Models']);
        $this->assertIsString($namespaces['Zemit\\Models']);
        
        // do this for real module testing
//        $this->assertFileExists($namespaces['Zemit\\Cli\\Tasks']);
//        $this->assertFileExists($namespaces['Zemit\\Cli\\Models']);
//        $this->assertFileExists($namespaces['Zemit\\Models']);
    }
    
    public function testGetNamespace(): void
    {
        $namespace = $this->module->getNamespace();
        $this->assertEquals('Zemit\\Cli', $namespace);
    }
    
    public function testGetDefaultNamespace(): void
    {
        $defaultNamespace = $this->module->getDefaultNamespace();
        $this->assertEquals('Zemit\\Cli\\Tasks', $defaultNamespace);
    }
    
    public function testGetDirname(): void
    {
        $dirname = $this->module->getDirname();
        $this->assertIsString($dirname);
        $this->assertStringEndsWith(DIRECTORY_SEPARATOR . 'Cli', $dirname);
        $this->assertFileExists($dirname);
    }
    
    public function testGetServices(): void
    {
        $this->module->getServices();
        
        // Phalcon Instances
        $this->assertInstanceOf(\Phalcon\Config\Config::class, $this->module->config);
        $this->assertInstanceOf(\Phalcon\Autoload\Loader::class, $this->module->loader);
        $this->assertInstanceOf(\Phalcon\Cli\Router::class, $this->module->router);
        $this->assertInstanceOf(\Phalcon\Cli\Dispatcher::class, $this->module->dispatcher);
        
        // Zemit Instances
        $this->assertInstanceOf(\Zemit\Config\Config::class, $this->module->config);
        $this->assertInstanceOf(\Zemit\Cli\Router::class, $this->module->router);
        $this->assertInstanceOf(\Zemit\Cli\Dispatcher::class, $this->module->dispatcher);
        
        // Interfaces
        $this->assertInstanceOf(\Zemit\Router\RouterInterface::class, $this->module->router);
//        $this->assertInstanceOf(\Phalcon\Cli\RouterInterface::class, $this->module->router);
        $this->assertInstanceOf(\Zemit\Dispatcher\DispatcherInterface::class, $this->module->dispatcher);
        $this->assertInstanceOf(\Phalcon\Cli\DispatcherInterface::class, $this->module->dispatcher);
    }
    
    public function testSetServices(): void
    {
        $this->module->getServices($this->di);
        $this->module->setServices($this->di);
        $this->assertSame($this->di->get('config'), $this->module->config);
        $this->assertSame($this->di->get('dispatcher'), $this->module->dispatcher);
        $this->assertSame($this->di->get('loader'), $this->module->loader);
        $this->assertSame($this->di->get('router'), $this->module->router);
    }
}
