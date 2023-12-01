<?php

namespace Zemit\Fractal;

use League\Fractal\TransformerAbstract;
use Phalcon\Di\InjectionAwareInterface;
use Zemit\Di\InjectableTrait;

class Transformer extends TransformerAbstract implements InjectionAwareInterface
{
    use InjectableTrait;
}
