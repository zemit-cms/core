<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Cli;

class ExceptionHandler
{
    private $outputStream;
    
    public function __construct(string|\Exception|\Throwable $e, mixed $outputStream = STDERR)
    {
        $this->outputStream = $outputStream;
        $message = is_string($e) ? $e : (string) $e;
        fwrite($this->outputStream, $message . PHP_EOL);
    }
}
