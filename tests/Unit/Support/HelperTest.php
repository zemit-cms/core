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

namespace Zemit\Tests\Unit\Support;

use Zemit\Support\Helper;
use Zemit\Support\HelperFactory;
use Zemit\Tests\Unit\AbstractUnit;

class HelperTest extends AbstractUnit
{
    private ?HelperFactory $helper;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->helper = $this->di->get('helper');
    }
    
    public function testLocaleInstanceFromDi(): void
    {
        $this->assertInstanceOf(HelperFactory::class, $this->helper);
    }
    
    public function testSlugify(): void
    {
        $tests = [
            'should-remain-the-same' => 'should-remain-the-same',
            'slugify-value' => 'Slugify Value',
            'another-slugify-value' => 'Another Slugify Value',
            'complex-slugify-value-with-some-special-characters' => 'Complex Slugify Value with some special characters!',
            'slugify-value-with-numbers123' => 'Slugify Value with Numbers123',
            'slugify-value-with-diacritics' => 'Slúgîfy Válúe wîth Díacrîtícs',
            'slugify-value-with-hyphen' => 'Slugify - Value with - hyphen',
            'slugify-value-with-space' => ' Slugify Value with space ',
            'slugify-value-with-multiple-spaces' => 'Slugify    Value with multiple   spaces',
        ];
        
        foreach ($tests as $expected => $value) {
            $this->assertEquals($expected, $this->helper->slugify($value));
            $this->assertEquals($expected, Helper::slugify($value));
        }
        
        $this->assertEquals('changed.delimiter', $this->helper->slugify('Changed Delimiter', [], '.'));
        $this->assertEquals('replaced:example', $this->helper->slugify('To Replace', ['To Replace' => 'Replaced-Example'], ':'));
    }
    
    public function testRecursiveMap(): void
    {
        $nestedArray = [
            'test' => 'test',
            'nesting' => [
                'nesting' => [
                    'test' => 'test',
                ],
            ],
        ];
        
        $result = $this->helper->recursiveMap($nestedArray, function ($value) {
            return 'mapped';
        });
        
        $expected = [
            'test' => 'mapped',
            'nesting' => [
                'nesting' => [
                    'test' => 'mapped',
                ],
            ],
        ];
        
        $this->assertNotEquals($nestedArray, $result);
        $this->assertEquals($expected, $result);
    }
    
    public function testFlattenKeys(): void
    {
        $nestedArray = [
            'Test' => 'test',
            'nesting' => [
                'nesting' => [
                    true,
                    'test' => 'test',
                    'false' => false,
                ],
            ],
        ];
        
        $expected = [
            'test' => 'test',
            'nesting' => false,
            'nesting.nesting' => true,
            'nesting.nesting.test' => 'test',
            'nesting.nesting.false' => false,
        ];
        $this->assertEquals($expected, $this->helper->flattenKeys($nestedArray));
        $this->assertEquals($expected, Helper::flattenKeys($nestedArray));
        
        $expected = [
            'test' => 'test',
            'nesting' => false,
            'nesting-nesting' => true,
            'nesting-nesting-test' => 'test',
            'nesting-nesting-false' => false,
        ];
        $this->assertEquals($expected, $this->helper->flattenKeys($nestedArray, '-'));
        $this->assertEquals($expected, Helper::flattenKeys($nestedArray, '-'));
        
        $expected = [
            'Test' => 'test',
            'nesting' => false,
            'nesting:nesting' => true,
            'nesting:nesting:test' => 'test',
            'nesting:nesting:false' => false,
        ];
        $this->assertEquals($expected, $this->helper->flattenKeys($nestedArray, ':', false));
        $this->assertEquals($expected, Helper::flattenKeys($nestedArray, ':', false));
    }
}
