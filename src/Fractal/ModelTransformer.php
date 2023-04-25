<?php

namespace Zemit\Fractal;

use League\Fractal\TransformerAbstract;
use Phalcon\Di\InjectionAwareInterface;
use Phalcon\Mvc\ModelInterface;
use Zemit\Di\InjectableTrait;

class ModelTransformer extends TransformerAbstract implements InjectionAwareInterface
{
    use InjectableTrait;
    
    public function transform(ModelInterface $model): array
    {
        return $model->toArray();
    }
}
