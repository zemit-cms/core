<?php

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit Team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PhalconKit\Tests\Unit\Config;

use PhalconKit\Tests\Unit\AbstractUnit;
use PhalconKit\Config\Config;

class ConfigTest extends AbstractUnit
{
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
}
