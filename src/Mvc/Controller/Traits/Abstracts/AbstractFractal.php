<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Traits\Abstracts;

use League\Fractal\Serializer\SerializerAbstract;
use League\Fractal\TransformerAbstract;
use Phalcon\Mvc\Model\ResultsetInterface;
use Phalcon\Mvc\ModelInterface;
use Zemit\Fractal\Manager;

trait AbstractFractal
{
    abstract public function getFractalManager(): Manager;
    
    abstract public function setFractalManager(?Manager $manager): void;
    
    abstract public function getFractalSerializer(): SerializerAbstract;
    
    abstract public function setFractalSerializer(SerializerAbstract $serializer): void;
    
    abstract public function getTransformer(): TransformerAbstract;
    
    abstract public function setTransformer(?TransformerAbstract $transformer = null): void;
    
    abstract public function hasTransformer(): bool;
    
    abstract public function transformModel(ModelInterface $model, ?TransformerAbstract $transformer = null, ?Manager $fractalManager = null): ?array;
    
    abstract public function transformResultset(ResultsetInterface $resultset, ?TransformerAbstract $transformer = null, ?Manager $fractalManager = null): ?array;
    
    abstract public function transformItem(mixed $data, ?TransformerAbstract $transformer = null, ?Manager $fractalManager = null): ?array;
    
    abstract public function transformCollection(mixed $data, ?TransformerAbstract $transformer = null, ?Manager $fractalManager = null): ?array;
}
