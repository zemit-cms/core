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

namespace PhalconKit\Mvc\Controller\Traits\Interfaces;

use League\Fractal\Serializer\SerializerAbstract;
use League\Fractal\TransformerAbstract;
use Phalcon\Mvc\Model\ResultsetInterface;
use PhalconKit\Fractal\Manager;

interface FractalInterface
{
    public function getFractalManager(): Manager;
    
    public function setFractalManager(?Manager $manager): void;
    
    public function getFractalSerializer(): SerializerAbstract;
    
    public function setFractalSerializer(SerializerAbstract $serializer): void;
    
    public function getTransformer(): TransformerAbstract;
    
    public function setTransformer(?TransformerAbstract $transformer = null): void;
    
    public function hasTransformer(): bool;
    
    public function transformModel(\Phalcon\Mvc\ModelInterface $model, ?TransformerAbstract $transformer = null, ?Manager $fractalManager = null): ?array;
    
    public function transformResultset(ResultsetInterface $resultset, ?TransformerAbstract $transformer = null, ?Manager $fractalManager = null): ?array;
    
    public function transformItem(mixed $data, ?TransformerAbstract $transformer = null, ?Manager $fractalManager = null): ?array;
    
    public function transformCollection(mixed $data, ?TransformerAbstract $transformer = null, ?Manager $fractalManager = null): ?array;
}
