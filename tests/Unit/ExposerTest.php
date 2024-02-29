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

use Zemit\Support\Exposer\Builder;
use Zemit\Support\Exposer\Exposer;
use Zemit\Tests\Unit\AbstractUnit;

class ExposerTest extends AbstractUnit
{
    public function testBuilder(): void
    {
        $builder = new Builder();
        $tests = [
            null,
            true,
            false,
            0,
            1,
            '',
            '\\',
            ' spaces ' => 'spaces',
            ' spaces .' => 'spaces',
            'test',
            'test.test',
            'test. . . . test' => 'test.test',
            'test. . . . test .' => 'test.test',
            '.test. . . . test .' => 'test.test',
            '!@#$%^&*()',
            '!@#$%^&*().!@#$%^&*()_+',
            ['test'],
            ['test' => 'test'],
            (object)['test' => 'test'],
        ];

        foreach ($tests as $key => $value) {
            $test = $key;
            $expected = $value;
            if (is_int($key)) {
                $test = $value;
            }

            // value
            $builder->setValue($test);
            $this->assertEquals($test, $builder->getValue());

            // parent
            $builder->setParent($test);
            $this->assertEquals($test, $builder->getParent());

            if (is_string($test)) {
                // key
                $this->assertEquals($expected, Builder::processKey($test));

                $builder->setKey($test);
                $this->assertEquals($expected, $builder->getKey());

                // context key
                $builder->setContextKey($test);
                $this->assertEquals($expected, $builder->getContextKey());

                // full key
                $this->assertEquals(trim($expected . '.' . $expected, '.'), $builder->getFullKey());
            }

            if (is_bool($test)) {
                // expose
                $builder->setExpose($test);
                $this->assertEquals($test, $builder->getExpose());

                // protected
                $builder->setProtected($test);
                $this->assertEquals($test, $builder->getProtected());
            }

            // columns
            if (is_array($test) || is_null($test)) {
                $builder->setColumns($test);
                $this->assertEquals($test, $builder->getColumns());
            }
        }

        // Expose
        $builder->setExpose(true);
        $this->assertTrue($builder->getExpose());
        $builder->setExpose(false);
        $this->assertFalse($builder->getExpose());

        // Protected
        $builder->setProtected(true);
        $this->assertTrue($builder->getProtected());
        $builder->setProtected(false);
        $this->assertFalse($builder->getProtected());
    }

    public function testExposer(): void
    {
        $test = [
            'test_null' => null,
            'test_empty' => '',
            'test_int' => 0,
            'test_float' => 0.1,
            'test_true' => true,
            'test_false' => false,
            'test_string' => 'string',
            'test_empty_array' => [],
            'test_empty_object' => (object)[],
            'test_array' => ['test' => 'test'],
            'test_object' => (object)['test' => 'test'],
            'test_removed' => 'test_removed',
            'test_removed_two' => 'test_removed_two',
            'test_after_removed' => 'test_after_removed',
            'test_replace_value' => 'test_value_before',
            'test_same_value_mb_sprintf' => 'test_same_value_mb_sprintf',
            'test_altered_value_mb_sprintf' => 'test_altered_value_mb_sprintf',
        ];
        $expected = $test;

        $builder = Exposer::createBuilder($test);
        $actual = Exposer::expose($builder);
        $this->assertEquals($expected, $actual);

        // @todo
        unset($expected['test_removed']);
        unset($expected['test_removed_two']);
        $expected['test_replace_value'] = 'test_value_after';
//        $expected['new_value'] = 'test';
        $expected['test_same_value_mb_sprintf'] = 'test_same_value_mb_sprintf';
        $expected['test_altered_value_mb_sprintf'] = 'test_altered_value_mb_sprintf!';
        $builder = Exposer::createBuilder($test, [
            true,
            'test_removed' => false,
            'test_removed_two' => false,
            'test_replace_value' => 'test_value_after',
            'new_value' => 'test',
            'test_get_value_sprint' => '%s',
            'test_altered_value_mb_sprintf' => '%s!',
        ]);
        $actual = Exposer::expose($builder);
        $this->assertEquals($expected, $actual);
    }
    
    public function testNestedExpose(): void
    {
        $array = [
            'test' => 'test',
            'test_hidden' => 'hidden',
            'nested' => [
                [
                    'id' => 1,
                    'test' => 'test',
                    'test_hidden' => 'hidden',
                ],
                [
                    'id' => 2,
                    'test' => 'test',
                    'test_hidden' => 'hidden',
                ],
            ],
        ];
        
        $result = [
            'test' => 'test',
            'nested' => [
                [
                    'id' => 1,
                    'test' => 'test',
                ],
                [
                    'id' => 2,
                    'test' => 'test',
                ],
            ],
        ];
        
        $builder = Exposer::createBuilder($array, [
            false,
            'test',
            'nested' => [
                'id',
                'test'
            ],
        ]);
        $actual = Exposer::expose($builder);
        $this->assertEquals($result, $actual);
        
        $builder = Exposer::createBuilder($array, [
            true,
            'test' => true,
            'test_hidden' => false,
            'nested' => [
                false,
                'id',
                'test'
            ],
        ]);
        $actual = Exposer::expose($builder);
        $this->assertEquals($result, $actual);
    }
}
