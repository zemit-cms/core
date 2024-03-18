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

namespace Unit\Support\Options;

use Zemit\Support\Options\Options;
use Zemit\Support\Options\OptionsInterface;
use Zemit\Tests\Unit\AbstractUnit;

class OptionsTest extends AbstractUnit
{
    public OptionsInterface $options;
    
    public function testConstruct(): void
    {
        $options = ['test' => 'test', 'nesting' => ['test' => 'nested']];
        $this->options = new class($options) implements OptionsInterface {
            use Options;
        };
        
        // test get all options
        $this->assertSame($options, $this->options->getOptions());
        
        // test default option
        $this->assertEquals('test', $this->options->getOption('test'));
        $this->assertTrue($this->options->hasOption('test'));
        $this->assertFalse($this->options->hasOption('non-existing-key'));
        $this->assertEquals('default', $this->options->getOption('non-existing-key', 'default'));
        
        // test changed option
        $this->options->setOption('test', 'changed');
        $this->assertEquals('changed', $this->options->getOption('test'));
        
        // reset options (should be the original options)
        $this->options->resetOptions();
        $this->assertEquals($options, $this->options->getOptions());
        
        // re-initialize options
        $newOptions = ['new' => 'test'];
        $this->options->initializeOptions($newOptions);
        $this->assertSame($newOptions, $this->options->getOptions());
        
        // old options should not exist and should be null
        $this->assertNull($this->options->getOption('test'));
        
        // clear options
        $this->options->clearOptions();
        $this->assertEquals([], $this->options->getOptions());
        
        // reset options (should be the reinitialized options)
        $this->options->resetOptions();
        $this->assertEquals($newOptions, $this->options->getOptions());
        
        // remove option
        $this->options->removeOption('new');
        $this->assertNull($this->options->getOption('new'));
        $this->assertEquals([], $this->options->getOptions());
    }
}
