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

use Zemit\Support\Helper;
use Zemit\Support\HelperFactory;
use Zemit\Support\Utils;

/**
 * Class ProviderTest
 * @package Tests\Unit
 */
class UtilsTest extends AbstractUnit
{
    public function testProvider(): void
    {
        $this->assertTrue(true);
        
        $collection = [
            [
                'transform' => [
                    'test.test',
                ],
                'assert' => [
                    'test.test' => true,
                ],
            ],
            [
                'transform' => [
                    'test',
                    'test.test',
                ],
                'assert' => [
                    'test' => true,
                    'test.test' => true,
                ],
            ],
            [
                'transform' => [
                    'test' => [
                        'test',
                    ],
                ],
                'assert' => [
                    'test' => false,
                    'test.test' => true,
                ],
            ],
            [
                'transform' => [
                    'test' => [
                        'test' => [
                            'test',
                        ],
                    ],
                ],
                'assert' => [
                    'test' => false,
                    'test.test' => false,
                    'test.test.test' => true,
                ],
            ],
            [
                'transform' => [
                    true,
                    'test' => [
                        true,
                        'test' => [
                            false,
                            'test',
                            'test2' => false,
                            'test3' => [
                                'test',
                            ],
                        ],
                    ],
                ],
                'assert' => [
                    '' => true,
                    'test' => true,
                    'test.test' => false,
                    'test.test.test' => true,
                    'test.test.test2' => false,
                    'test.test.test3' => false,
                    'test.test.test3.test' => true,
                ],
            ],
            [
                'transform' => [
                    'test' => function () {
                        return true;
                    },
                    'test2' => function () {
                        return [
                            'test',
                        ];
                    },
                    'test3' => function () {
                        return [
                            'test' => function () {
                                return false;
                            },
                        ];
                    },
                    'test4' => function () {
                        return [
                            'test' => function () {
                                return [
                                    true,
                                    'test' => false,
                                ];
                            },
                        ];
                    },
                ],
                'assert' => [
                    'test' => true,
                    'test2' => false,
                    'test2.test' => true,
                    'test3' => false,
                    'test3.test' => false,
                    'test4' => false,
                    'test4.test' => true,
                    'test4.test.test' => false,
                ],
            ],
        ];
        
        foreach ($collection as $key => $item) {
            $this->assertEquals(
                $item['assert'],
                Helper::flattenKeys($item['transform']),
                'Transform::flattenKeys failed for key `' . $key . '`'
            );
            $this->assertEquals(
                $item['assert'],
                (new HelperFactory())->flattenKeys($item['transform']),
                'Transform::flattenKeys failed for key `' . $key . '`'
            );
        }
    }
    
    public function testSetUnlimitedRuntime(): void
    {
        Utils::setUnlimitedRuntime();
        $this->assertEquals('-1', ini_get('memory_limit'), 'memory_limit');
        $this->assertEquals('0', ini_get('max_execution_time'), 'max_execution_time');
        $this->assertEquals('-1', ini_get('max_input_time'), 'max_input_time');
    }
    
    public function testGetNamespace(): void
    {
        $namespace = Utils::getNamespace($this);
        $this->assertIsString($namespace);
        $this->assertEquals(__NAMESPACE__, $namespace);
        
        $namespace = Utils::getNamespace(new Utils());
        $this->assertEquals('Zemit\\Support', $namespace);
    }
    
    public function testGetDirname(): void
    {
        $dirname = Utils::getDirname($this);
        $this->assertIsString($dirname);
        $this->assertEquals(__DIR__, $dirname);
        
        $dirname = Utils::getDirname(new Utils());
        $this->assertEquals(dirname(__DIR__, 2) . '/src/Support', $dirname);
    }
    
    public function testGetMemoryUsage(): void
    {
        $memoryUsage = Utils::getMemoryUsage();
        
        $this->assertIsString($memoryUsage['memory']);
        $this->assertIsString($memoryUsage['memoryPeak']);
        $this->assertIsString($memoryUsage['realMemory']);
        $this->assertIsString($memoryUsage['realMemoryPeak']);
    }
}
