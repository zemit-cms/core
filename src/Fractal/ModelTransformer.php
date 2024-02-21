<?php

namespace Zemit\Fractal;

use League\Fractal\TransformerAbstract;
use Phalcon\Di\InjectionAwareInterface;
use Zemit\Di\InjectableTrait;
use Phalcon\Mvc\Model;

class ModelTransformer extends TransformerAbstract implements InjectionAwareInterface
{
    use InjectableTrait;
    
    public function transform(Model $model): array
    {
        return $model->toArray();
    }
}
