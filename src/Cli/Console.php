<?php

use Phalcon\Cli\Console as PhalconConsole;

class Console extends PhalconConsole
{
    public function __construct(DiInterface $dependencyInjector = null)
    {
        parent::__construct($dependencyInjector);
    }
}