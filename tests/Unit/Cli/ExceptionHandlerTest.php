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
use Zemit\Cli\ExceptionHandler;
use Zemit\Tests\Unit\AbstractUnit;

class ExceptionHandlerTest extends AbstractUnit
{
    protected function setUp(): void
    {
    }
    
    public function testExceptionHandler(): void
    {
        $testException = new \Exception('Test exception');
        
        // Create a memory stream to capture the output
        $memoryStream = fopen('php://memory', 'r+');
        
        // Instantiate your handler with the memory stream
        new ExceptionHandler($testException, $memoryStream);
        
        // Rewind and read the content of the memory stream
        rewind($memoryStream);
        $output = stream_get_contents($memoryStream);
        
        // Assert the output contains your exception message
        $this->assertStringContainsString('Test exception', $output);
        
        // Clean up
        fclose($memoryStream);
    }
}
