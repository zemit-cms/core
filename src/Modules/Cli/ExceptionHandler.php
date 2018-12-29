<?php

namespace Zemit\Modules\Cli;

class ExceptionHandler
{
    public function __construct($e)
    {
        fwrite(STDERR, $e . PHP_EOL);
    }
}