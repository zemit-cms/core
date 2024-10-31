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

namespace Zemit\Tests\Unit\Functions;

use Zemit\Tests\Unit\AbstractUnit;

class ArrayUnsetRecursiveTest extends AbstractUnit
{
    protected function setUp(): void
    {
    }
    
    public function testSimpleArray(): void
    {
        $array = ['a' => 1, 'b' => 2, 'c' => 3];
        $keys = ['a', 'c'];
        $expectedArray = ['b' => 2];
        $expectedCount = 2;
        
        $this->assertEquals($expectedCount, array_unset_recursive($array, $keys));
        $this->assertEquals($expectedArray, $array);
    }
    
    public function testNestedArrays(): void
    {
        $array = ['a' => 1, 'b' => ['c' => 3, 'd' => 4], 'e' => 5];
        $keys = ['d', 'e'];
        $expectedArray = ['a' => 1, 'b' => ['c' => 3]];
        $expectedCount = 2;
        
        $this->assertEquals($expectedCount, array_unset_recursive($array, $keys));
        $this->assertEquals($expectedArray, $array);
    }
    
    public function testStrictParameter(): void
    {
        $array = [10 => 'integer'];
        $keys = ['10'];
        $expectedArrayStrict = [10 => 'integer'];
        $expectedArrayNonStrict = [];
        
        $this->assertEquals(0, array_unset_recursive($array, $keys, true));
        $this->assertEquals($expectedArrayStrict, $array);
        
        // Reset array for non-strict test
        $array = ['10' => 'string'];
        
        $this->assertEquals(1, array_unset_recursive($array, $keys, false));
        $this->assertEquals($expectedArrayNonStrict, $array);
    }
    
    public function testEmptyKeyList(): void
    {
        $array = ['a' => 1, 'b' => 2];
        $keys = [];
        $expectedArray = $array;
        
        $this->assertEquals(0, array_unset_recursive($array, $keys));
        $this->assertEquals($expectedArray, $array);
    }
    
    public function testArrayNotContainingKeyListItems(): void
    {
        $array = ['a' => 1, 'b' => 2];
        $keys = ['c', 'd'];
        $expectedArray = $array;
        
        $this->assertEquals(0, array_unset_recursive($array, $keys));
        $this->assertEquals($expectedArray, $array);
    }
}
