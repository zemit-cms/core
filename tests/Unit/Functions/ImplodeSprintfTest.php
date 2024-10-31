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

class ImplodeSprintfTest extends AbstractUnit
{
    protected function setUp(): void
    {
    }
    
    public function testImplodeSprintfBasic(): void
    {
        $array = ['apple', 'banana', 'cherry'];
        $this->assertEquals('apple banana cherry', implode_sprintf($array));
    }
    
    public function testImplodeSprintfAssociativeArray()
    {
        $array = ['first' => 'apple', 'second' => 'banana'];
        $format = '(%s:%s)';
        $this->assertEquals('(apple:first) (banana:second)', implode_sprintf($array, ' ', $format));
    }
    
    public function testImplodeSprintfNumericFormat()
    {
        $array = [1, 2, 3];
        $this->assertEquals('1 2 3', implode_sprintf($array, ' ', '%d'));
    }
    
    public function testImplodeSprintfComplexFormat()
    {
        $array = ['apple', 'banana'];
        $format = '[%2$s:%1$s]';
        $this->assertEquals('[0:apple] [1:banana]', implode_sprintf($array, ' ', $format));
    }
    
    public function testImplodeSprintfEmptyArray()
    {
        $this->assertEquals('', implode_sprintf([]));
    }
    
    public function testImplodeSprintfSingleElement()
    {
        $array = ['apple'];
        $this->assertEquals('apple', implode_sprintf($array));
    }
    
    public function testImplodeSprintfCustomGlue()
    {
        $array = ['apple', 'banana'];
        $glue = ', ';
        $this->assertEquals('apple, banana', implode_sprintf($array, $glue));
    }
    
    public function testImplodeSprintfMultibyteCharacters()
    {
        $array = ['苹果', '香蕉'];
        $this->assertEquals('苹果 香蕉', implode_sprintf($array));
    }
    
    public function testImplodeSprintfNullValues()
    {
        $array = ['apple', null, 'banana'];
        $this->assertEquals('apple banana', implode_sprintf($array));
    }
    
    public function testImplodeSprintfMixedValues()
    {
        $array = ['apple', 42, null, 'banana'];
        $this->assertEquals('apple 42 banana', implode_sprintf($array));
    }
}
