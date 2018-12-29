<?php

use Colors\Color;

class Console extends PhalconConsole
{
    public function __construct(DiInterface $dependencyInjector = null)
    {
        parent::__construct($dependencyInjector);
    }
}