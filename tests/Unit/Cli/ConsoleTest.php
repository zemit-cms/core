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

namespace Zemit\Tests\Unit\Cli;

use Zemit\Bootstrap;
use Zemit\Tests\Unit\AbstractUnit;

class ConsoleTest extends AbstractUnit
{
    public \Zemit\Cli\Console $console;
    
    protected string $mode = Bootstrap::MODE_CLI;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->console = $this->di->get('console');
    }
    
    public function testConsoleFromDi(): void
    {
        $this->assertInstanceOf(\Phalcon\Cli\Console::class, $this->console);
        $this->assertInstanceOf(\Zemit\Cli\Console::class, $this->console);
    }
}
