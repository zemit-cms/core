<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Traits;

use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\SerializerAbstract;
use League\Fractal\TransformerAbstract;
use Phalcon\Mvc\Model\ResultsetInterface;
use Phalcon\Mvc\ModelInterface;
use Zemit\Fractal\Manager;
use Zemit\Fractal\ModelTransformer;
use Zemit\Fractal\Serializer\RawArraySerializer;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractFractal;

/**
 * This trait provides methods for working with Fractal, a library for transforming data structures.
 */
trait Fractal
{
    use AbstractFractal;
    
    public Manager $fractalManager;
    public SerializerAbstract $fractalSerializer;
    public TransformerAbstract $transformer;
    
    /**
     * Get the Fractal Manager object.
     *
     * This method returns the Fractal Manager object used for transforming data.
     * If the Fractal Manager object is not already created, it will be created
     * and initialized with the Fractal Serializer before being returned.
     *
     * @return Manager The Fractal Manager object.
     */
    public function getFractalManager(): Manager
    {
        if (!isset($this->fractalManager)) {
            $this->fractalManager = new Manager();
            $this->fractalManager->setSerializer($this->getFractalSerializer());
        }
        
        return $this->fractalManager;
    }
    
    /**
     * Set the Fractal Manager for the class.
     *
     * @param Manager|null $manager The Fractal Manager to be set. If null, the Fractal Manager will be unset.
     *
     * @return void
     */
    public function setFractalManager(?Manager $manager): void
    {
        $this->fractalManager = $manager;
    }
    
    /**
     * Get the fractal serializer for the class.
     *
     * @return SerializerAbstract The fractal serializer instance.
     */
    public function getFractalSerializer(): SerializerAbstract
    {
        if (!isset($this->fractalSerializer)) {
            $this->fractalSerializer = new RawArraySerializer();
        }
        
        return $this->fractalSerializer;
    }
    
    /**
     * Set the Fractal serializer for the class.
     *
     * @param SerializerAbstract $serializer The Fractal serializer to be set.
     *
     * @return void
     */
    public function setFractalSerializer(SerializerAbstract $serializer): void
    {
        $this->fractalSerializer = $serializer;
    }
    
    /**
     * Get the transformer for the class.
     *
     * If the transformer has not been set, a new instance of ModelTransformer will be created.
     *
     * @return TransformerAbstract The transformer for the class.
     */
    public function getTransformer(): TransformerAbstract
    {
        if (!isset($this->transformer)) {
            $this->transformer = new ModelTransformer();
        }
        
        return $this->transformer;
    }
    
    /**
     * Set the transformer for the class.
     *
     * @param TransformerAbstract|null $transformer The transformer to be set. If null, the transformer will be unset.
     * 
     * @return void
     */
    public function setTransformer(?TransformerAbstract $transformer = null): void
    {
        $this->transformer = $transformer;
    }
    
    /**
     * Determine if a default transformer has been set for the fractal manager
     *
     * @return bool Returns true if a default transformer has been set, false otherwise
     */
    public function hasTransformer(): bool
    {
        return (bool)$this->transformer;
    }
    
    /**
     * Transform a model using a transformer and optionally a fractal manager.
     *
     * @param ModelInterface $model The model to transform.
     * @param TransformerAbstract|null $transformer The transformer to use. If not provided, the default transformer will be used.
     * @param Manager|null $fractalManager The fractal manager to use. If not provided, the default fractal manager will be used.
     *
     * @return array|null The transformed model as an array, or null if the transformation fails.
     */
    public function transformModel(ModelInterface $model, ?TransformerAbstract $transformer = null, ?Manager $fractalManager = null): ?array
    {
        return $this->transformItem($model, $transformer, $fractalManager);
    }
    
    /**
     * Transforms a resultset using the provided transformer and fractal manager.
     *
     * @param ResultsetInterface $resultset The resultset to be transformed.
     * @param TransformerAbstract|null $transformer The transformer instance to be used for transformation (optional).
     * @param Manager|null $fractalManager The fractal manager instance to be used for transformation (optional).
     *
     * @return array|null The transformed resultset as an array, or null if the transformation failed.
     */
    public function transformResultset(ResultsetInterface $resultset, ?TransformerAbstract $transformer = null, ?Manager $fractalManager = null): ?array
    {
        return $this->transformCollection($resultset, $transformer, $fractalManager);
    }
    
    /**
     * Transform an item using the specified transformer and Fractal manager
     *
     * @param mixed $data The data to transform
     * @param TransformerAbstract|null $transformer The transformer to use (optional, default is null)
     * @param Manager|null $fractalManager The Fractal manager to use (optional, default is null)
     *
     * @return array|null The transformed item as an array
     */
    public function transformItem(mixed $data, ?TransformerAbstract $transformer = null, ?Manager $fractalManager = null): ?array
    {
        $fractalManager ??= $this->getFractalManager();
        $transformer ??= $this->getTransformer();
        return $fractalManager->createData(new Item($data, $transformer))->toArray();
    }
    
    /**
     * Transform a collection of data using a specified transformer and Fractal manager.
     *
     * @param mixed $data The collection of data to be transformed.
     * @param TransformerAbstract|null $transformer The transformer to be used. If not provided, the default transformer will be used.
     * @param Manager|null $fractalManager The Fractal manager to be used. If not provided, the default Fractal manager will be used.
     * 
     * @return array|null The transformed data as an array.
     */
    public function transformCollection(mixed $data, ?TransformerAbstract $transformer = null, ?Manager $fractalManager = null): ?array
    {
        $fractalManager ??= $this->getFractalManager();
        $transformer ??= $this->getTransformer();
        return $fractalManager->createData(new Collection($data, $transformer))->toArray();
    }
}
