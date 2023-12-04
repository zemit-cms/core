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

namespace Unit;

use Zemit\Tests\Unit\AbstractUnit;
use Zemit\Config\Config;

class ConfigTest extends AbstractUnit
{
//    public function setUp(): void
//    {
//    }
    
    public function testPathToArray(): void
    {
        $config = new Config();
        
        $paths = [
            'test',
            'test1.test2',
            'test2.test3.test4.',
            '0',
            '1.2',
            '2.3.4.',
            '!@#$%^&*()',
        ];
        
        $tests = [
            ['value' => '', 'expected' => ['']],
            ['value' => null, 'expected' => null],
            ['value' => ['test'], 'expected' => ['test']],
            ['value' => ['test' => 'test2'], 'expected' => ['test' => 'test2']],
            ['value' => ['test', 'test'], 'expected' => ['test', 'test']],
            ['value' => 'test', 'expected' => ['test']],
            ['value' => '!@#$%^&*()', 'expected' => ['!@#$%^&*()']],
            ['value' => 1, 'expected' => [1]],
            ['value' => 1.1, 'expected' => [1.1]],
            ['value' => true, 'expected' => [true]],
            ['value' => false, 'expected' => [false]],
            ['value' => Config::class, 'expected' => [Config::class]],
        ];
        
        foreach ($paths as $path) {
            foreach ($tests as $test) {
                $config->remove($path);
                
                $nullOrArray = isset($test['value']) ? (array)$test['value'] : $test['value'];
                $actual = $config->pathToArray($path, $nullOrArray);
                $this->assertEquals($test['expected'], $actual);
                $this->assertNull($config->pathToArray($path));
                if (!is_null($actual)) {
                    $this->assertIsArray($actual);
                }
                
                $config->set($path, $test['value']);
                $actual = $config->pathToArray($path);
                $this->assertEquals($test['expected'], $actual);
                
                $config->set($path, (object)$test['value']);
                $actual = $config->pathToArray($path);
                $this->assertIsArray($actual);
                $this->assertEquals((array)(object)$test['value'], $actual, $path . ' : ' . json_encode($test));
            }
        }
    }
    
    public function testDefaultConfig(): void
    {
        $config = new \Zemit\Bootstrap\Config();
        $keys = [
            'phalcon',
            'core',
            'app',
            'url',
            'php',
            'debug',
            'response',
            'identity',
            'models',
            'providers',
            'logger',
            'filters',
            'modules',
            'router',
            'view',
            'gravatar',
            'reCaptcha',
            'locale',
            'translate',
            'session',
            'module',
            'security',
            'cache',
            'metadata',
            'annotations',
            'database',
            'mailer',
            'cookies',
            'aws',
            'oauth2',
            'openai',
            'imap',
            'dotenv',
            'client',
            'permissions',
        ];
        
        // Default Configs should be defined
        foreach ($keys as $key) {
            $this->assertTrue($config->has($key));
        }
        
        // Every first level key should be grouped
        $keys = $config->getKeys();
        
        foreach ($keys as $key) {
            // Should be a Config object
            $this->assertInstanceOf(\Phalcon\Config\Config::class, $config->$key);
            $this->assertInstanceOf(\Phalcon\Config\Config::class, $config->get($key));
            $this->assertInstanceOf(\Phalcon\Config\Config::class, $config->path($key));
            
            // Should be able to extract array
            $this->assertIsArray($config->$key->toArray());
            $this->assertIsArray($config->get($key)->toArray());
            $this->assertIsArray($config->path($key)->toArray());
    
            // Should be clearable
            $config->get($key)->clear();
            $this->assertTrue($config->has($key));
            $this->assertEmpty($config->get($key)->toArray());
            $this->assertEquals(0, $config->get($key)->count());
            
            // Should be mutable
            $config->remove($key);
            $this->assertFalse($config->has($key));
            $this->assertNull($config->$key);
            $this->assertNull($config->get($key));
            $this->assertNull($config->path($key));
        }
        
        $this->assertNull($config->get('!@#$%^&*()'));
        $this->assertEquals(1, $config->get('!@#$%^&*()', 1));
    }
    
    public function testGetModelClass(): void
    {
        $config = new \Zemit\Bootstrap\Config();
        $models = $config->get('models')->toArray();
        
        foreach ($models as $from => $to) {
            // Should be itself by default
            $this->assertEquals($to, $config->getModelClass($from));
            $this->assertEquals($to, $from);
            
            // Should be mutable
            $config->setModelClass($from, self::class);
            $this->assertEquals(self::class, $config->getModelClass($from));
    
            // Should be reset
            $config->resetModelClass($from);
            $this->assertEquals($from, $config->getModelClass($from));
        }
    
        // Should fall back to itself
        $this->assertEquals(self::class, $config->getModelClass(self::class));
    
        // Should be mutable
        $config->setModelClass(self::class, Config::class);
        $this->assertEquals(Config::class, $config->getModelClass(self::class));
    }
}
