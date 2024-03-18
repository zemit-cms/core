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

namespace Unit\Functions;

use Zemit\Tests\Unit\AbstractUnit;

class ImplodeMbSprintfTest extends AbstractUnit
{
    protected function setUp(): void
    {
    }
    
    public function testImplodeMbSprintfMultibyte(): void
    {
        $array = ['苹果', '香蕉', '樱桃'];
        $this->assertEquals('苹果 香蕉 樱桃', implode_mb_sprintf($array));
    }
    
    public function testImplodeMbSprintfBasicMultibyte(): void
    {
        $array = ['苹果', '香蕉', '樱桃'];
        $this->assertEquals('苹果 香蕉 樱桃', implode_mb_sprintf($array));
    }
    
    public function testImplodeMbSprintfEmptyArray(): void
    {
        $this->assertEquals('', implode_mb_sprintf([]));
    }
    
    public function testImplodeMbSprintfCustomGlue(): void
    {
        $array = ['苹果', '香蕉'];
        $glue = '、';
        $this->assertEquals('苹果、香蕉', implode_mb_sprintf($array, $glue));
    }
    
    public function testImplodeMbSprintfComplexFormat(): void
    {
        $array = ['苹果', '香蕉'];
        $format = '[%s]';
        $this->assertEquals('[苹果] [香蕉]', implode_mb_sprintf($array, ' ', $format));
    }
    
    public function testImplodeMbSprintfSingleElement(): void
    {
        $array = ['苹果'];
        $this->assertEquals('苹果', implode_mb_sprintf($array));
    }
    
    // @todo
//    public function testImplodeMbSprintfDifferentEncodings(): void
//    {
//        $array = [mb_convert_encoding('苹果', 'ISO-8859-1', 'UTF-8'), 'apple'];
//        $this->assertEquals('苹果 apple', implode_mb_sprintf($array, ' ', '%s', 'ISO-8859-1'));
//    }
    
    public function testImplodeMbSprintfNumericFormats(): void
    {
        $array = ['123', '456', '789'];
        $this->assertEquals('123 456 789', implode_mb_sprintf($array, ' ', '%d'));
    }
    
    public function testImplodeMbSprintfMixedValues(): void
    {
        $array = ['苹果', 42, null, 'banana'];
        $this->assertEquals('苹果 42 banana', implode_mb_sprintf($array));
    }
    
    public function testImplodeMbSprintfWithNullValues(): void
    {
        $array = ['苹果', null, '香蕉'];
        $this->assertEquals('苹果 香蕉', implode_mb_sprintf($array));
    }
}
