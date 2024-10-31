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

class SprintfnTest extends AbstractUnit
{
    protected function setUp(): void
    {
    }
    
    public function testSprintfnBasic(): void
    {
        $format = 'Name: %name$s, Age: %age$d';
        $args = ['name' => 'Alice', 'age' => 30];
        $this->assertEquals('Name: Alice, Age: 30', sprintfn($format, $args));
    }
    
    public function testSprintfnMultipleNamedArguments(): void
    {
        $format = 'Name: %name$s, Age: %age$d';
        $args = ['name' => 'Alice', 'age' => 30];
        $this->assertEquals('Name: Alice, Age: 30', sprintfn($format, $args));
    }
    
    public function testSprintfnArgumentReuse(): void
    {
        $format = 'Name: %name$s, Name Again: %name$s';
        $args = ['name' => 'Alice'];
        $this->assertEquals('Name: Alice, Name Again: Alice', sprintfn($format, $args));
    }
    
    public function testSprintfnUnmatchedArguments(): void
    {
        $format = 'Name: %name$s';
        $args = ['name' => 'Alice', 'unused' => 'Value'];
        $this->assertEquals('Name: Alice', sprintfn($format, $args));
    }
    
    public function testSprintfnMissingArguments(): void
    {
        $format = 'Name: %name$s, Age: %age$d';
        $args = ['name' => 'Alice']; // Missing 'age'
        
        $this->setErrorHandler();
        $this->expectException(\Exception::class);
        $this->assertFalse(sprintfn($format, $args));
    }
    
    public function testSprintfnMixedArguments(): void
    {
        $format = 'Name: %name$s, Number: %1$d';
        $args = ['name' => 'Alice'];
        $this->assertEquals('Name: Alice, Number: 0', sprintfn($format, $args, 42));
    }
    
    public function testSprintfnSpecialCharacterHandling(): void
    {
        $format = 'Data: %special_char$s';
        $args = ['special_char' => '$pecial@Character!'];
        $this->assertEquals('Data: $pecial@Character!', sprintfn($format, $args));
    }
    
    // @todo maybe support nested arguments or fail
//    public function testSprintfnNestedNamedArguments(): void
//    {
//        $format = 'Outer: %outer$s, Inner: %outer.inner$s';
//        $args = ['outer' => ['inner' => 'InnerValue']];
//        $this->assertFalse(sprintfn($format, $args)); // Expected to fail as nested arguments are not supported
//    }
    
    // @todo
//    public function testSprintfnInvalidFormatString(): void
//    {
//        $format = 'Broken % Format';
//        $args = ['name' => 'Alice'];
//        $this->assertFalse(sprintfn($format, $args));
//    }
    
    public function testSprintfnEmptyFormatString(): void
    {
        $this->assertEquals('', sprintfn('', []));
    }
    
    public function testSprintfnComplexFormats(): void
    {
        $format = 'Name: %-10s | Age: %04d | Salary: %.2f';
        $args = ['name' => 'Alice', 'age' => 30, 'salary' => 12345.678];
        $this->assertEquals('Name: Alice      | Age: 0030 | Salary: 12345.68', sprintfn($format, $args));
    }
    
    public function testSprintfnMissingArgument(): void
    {
        $format = 'Name: %name$s, Age: %age$d';
        $args = ['name' => 'Alice']; // 'age' argument is missing
        
        $this->setErrorHandler();
        $this->expectException(\Exception::class);
        $this->assertFalse(sprintfn($format, $args));
    }
}
