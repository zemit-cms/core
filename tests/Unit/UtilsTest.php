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

//use Zemit\Utils\Transform;
use Zemit\Utils\Transform;

/**
 * Class ProviderTest
 * @package Tests\Unit
 */
class UtilsTest extends AbstractUnit
{
    public $collection = [
    
    ];
    
    /**
     * Testing the bootstrap service
     */
    public function testProvider() {
        $this->assertTrue(true);
        
        $this->collection = [
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
                        'test'
                    ]
                ],
                'assert' => [
                    'test' => false,
                    'test.test' => true
                ],
            ],
            [
                'transform' => [
                    'test' => [
                        'test' => [
                            'test'
                        ],
                    ]
                ],
                'assert' => [
                    'test' => false,
                    'test.test' => false,
                    'test.test.test' => true
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
                                'test'
                            ]
                        ],
                    ]
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
        
        foreach ($this->collection as $key => $item) {
            $this->assertEquals(
                $item['assert'],
                Transform::_flattenKeys($item['transform']),
                'Transform::_flattenKeys failed for key `' . $key . '`'
            );
        }
    }
    
}
