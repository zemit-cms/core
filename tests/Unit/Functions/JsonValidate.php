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

class JsonValidate extends AbstractUnit
{
    protected function setUp(): void
    {
    }
    
    public function testValidJson(): void
    {
        $this->assertTrue(json_validate('{"name":"John", "age":30, "city":"New York"}'));
    }
    
    public function testInvalidJson(): void
    {
        $this->assertFalse(json_validate('{name:"John", age:30, city:"New York"}'));
    }
    
    public function testValidJsonWithDepth(): void
    {
        $nestedJson = '{"level1":{"level2":{"level3":"value"}}}';
        $this->assertTrue(json_validate($nestedJson, 4));
    }
    
    public function testInvalidJsonWithDepth(): void
    {
        $nestedJson = '{"level1":{"level2":{"level3":"value"}}}';
        $this->assertFalse(json_validate($nestedJson, 2));
    }
    
    // @todo doesnt work with native php83 json_validate
//    public function testJsonWithFlags(): void
//    {
//        $json = '[1,2,3,4]';
//        $this->assertTrue(json_validate($json, 512, JSON_NUMERIC_CHECK));
//    }
    
    public function testEdgeCases(): void
    {
        // Empty string
        $this->assertFalse(json_validate(''));
        
        // Single value
        $this->assertTrue(json_validate('123'));
        $this->assertTrue(json_validate('"A string"'));
        
        // Large string
        $largeJson = str_repeat('{"a":"b"},', 1000);
        $largeJson = '[' . rtrim($largeJson, ',') . ']';
        $this->assertTrue(json_validate($largeJson));
    }
    
    public function testDeepNesting(): void
    {
        $deepNestingJson = str_repeat('{"a":', 1000) . '"value"' . str_repeat('}', 1000);
        $this->assertFalse(json_validate($deepNestingJson));
        $this->assertTrue(json_validate($deepNestingJson, 1024));
    }
    
    public function testNonStringJson(): void
    {
        $this->assertTrue(json_validate('123'));
        $this->assertTrue(json_validate('null'));
    }
    
    // @todo doesnt work with native php83 json_validate
//    public function testJsonWithAllFlags(): void
//    {
//        $json = '{"number": "3.14"}';
//        $flags = JSON_NUMERIC_CHECK | JSON_HEX_QUOT;
//        $this->assertTrue(json_validate($json, 512, $flags));
//    }
    
    public function testLargeJsonString(): void
    {
        $largeJson = '{"data":[' . str_repeat('{"id":1,"value":"test"},', 10000) . '{"id":1,"value":"test"}]}';
        $this->assertTrue(json_validate($largeJson));
    }
    
    public function testSpecialCharactersInJson(): void
    {
        $json = '{"text":"Line1\nLine2\tTabbed"}';
        $this->assertTrue(json_validate($json));
    }
    
    public function testMalformedJsonStructures(): void
    {
        $missingQuotes = '{name:"John", "age":30}';
        $extraComma = '{"name":"John", "age":30,}';
        $this->assertFalse(json_validate($missingQuotes));
        $this->assertFalse(json_validate($extraComma));
    }
}
