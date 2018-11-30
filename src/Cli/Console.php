<?php

namespace Zemit\Core\Cli;

use Phalcon\Cli\Console as PhalconConsole;

class Console extends PhalconConsole
{
    public function __construct(\Phalcon\DiInterface $dependencyInjector = null)
    {
        parent::__construct($dependencyInjector);
    }
}