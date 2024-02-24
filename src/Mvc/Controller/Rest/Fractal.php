<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Rest;

use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\SerializerAbstract;
use League\Fractal\TransformerAbstract;
use Phalcon\Mvc\Model\ResultsetInterface;
use Phalcon\Mvc\ModelInterface;
use Zemit\Fractal\Manager;
use Zemit\Fractal\ModelTransformer;
use Zemit\Fractal\Serializer\RawArraySerializer;

trait Fractal
{
    public ?Manager $fractalManager;
    public ?SerializerAbstract $fractalSerializer;
    public ?TransformerAbstract $transformer;
    
    /**
     * Get the default fractal manager
     */
    public function getFractalManager(): Manager
    {
        if (!$this->fractalManager) {
            $this->fractalManager = new Manager();
            $this->fractalManager->setSerializer($this->getFractalSerializer());
        }
        
        return $this->fractalManager;
    }
    
    /**
     * Set the default fractal manager
     */
    public function setFractalManager(?Manager $manager): void
    {
        $this->fractalManager = $manager;
    }
    
    /**
     * Get the default fractal serializer
     */
    public function getFractalSerializer(): SerializerAbstract
    {
        if (!$this->fractalSerializer) {
            $this->fractalSerializer = new RawArraySerializer();
        }
        
        return $this->fractalSerializer;
    }
    
    /**
     * Set the default fractal serializer
     */
    public function setFractalSerializer(SerializerAbstract $serializer): void
    {
        $this->fractalSerializer = $serializer;
    }
    
    /**
     * Get the default transformer for the fractal manager
     */
    public function getTransformer(): ?TransformerAbstract
    {
        if (!$this->transformer) {
            $this->transformer = new ModelTransformer();
        }
        
        return $this->transformer;
    }
    
    /**
     * Set a default transformer for the fractal manager
     */
    public function setTransformer(?TransformerAbstract $transformer = null): void
    {
        $this->transformer = $transformer;
    }
    
    /**
     * Return true if the transformer is defined
     */
    public function hasTransformer(): bool
    {
        return (bool)$this->transformer;
    }
    
    /**
     * Transform the model using the fractal manager, serializer and transformer
     */
    public function transformModel(ModelInterface $model, ?TransformerAbstract $transformer = null, ?Manager $fractalManager = null): ?array
    {
        $fractalManager ??= $this->getFractalManager();
        $transformer ??= $this->getTransformer();
        return $fractalManager->createData(new Item($model, $transformer))->toArray();
    }
    
    /**
     * Transform the resultset models using the fractal manager, serializer and transformer
     */
    public function transformResultset(ResultsetInterface $resultset, ?TransformerAbstract $transformer = null, ?Manager $fractalManager = null): ?array
    {
        $fractalManager ??= $this->getFractalManager();
        $transformer ??= $this->getTransformer();
        return $fractalManager->createData(new Collection($resultset, $transformer))->toArray();
    }
}
