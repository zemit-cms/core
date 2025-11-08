<?php

declare(strict_types=1);

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit Team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace PhalconKit\Cli;

class ExceptionHandler
{
    public function __construct(
        private string|\Exception|\Throwable $e,
        private readonly mixed $outputStream = STDERR,
    ) {}
    
    public function write(): void
    {
        fwrite(
            $this->outputStream,
            (is_string($this->e) ? $this->e : (string) $this->e) . PHP_EOL
        );
    }
}
