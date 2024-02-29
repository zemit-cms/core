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

use Phalcon\Mvc\ModelInterface;
use Zemit\Mvc\Controller\AbstractTrait\AbstractInjectable;

trait ModelName
{
    use AbstractInjectable;
    
    protected ?string $modelName;
    protected ?array $modelNamespaces;
    
    /**
     * Get the default model class name
     */
    public function getModelName(): ?string
    {
        if (!$this->modelName) {
            $this->modelName = $this->getModelNameFromController();
        }
        
        return $this->modelName;
    }
    
    /**
     * Set the default model class name
     */
    public function setModelName(?string $modelName = null): void
    {
        $this->modelName = $modelName;
    }
    
    /**
     * Get the default model namespaces
     */
    public function getModelNamespaces(): array
    {
        if (!$this->modelNamespaces) {
            $this->modelNamespaces = $this->loader->getNamespaces();
        }
        
        return $this->modelNamespaces;
    }
    
    /**
     * Set the default model namespaces
     */
    public function setModelNamespaces(?array $modelNamespaces = []): void
    {
        $this->modelNamespaces = $modelNamespaces;
    }
    
    /**
     * Try to find the appropriate model which would suit the current controller name
     */
    public function getModelNameFromController(?array $namespaces = null, string $needle = 'Models'): ?string
    {
        $model = ucfirst(
            $this->helper->camelize(
                $this->helper->uncamelize(
                    $this->getControllerName()
                )
            )
        );
        
        if (class_exists($model)) {
            return $model;
        }
        
        $namespaces ??= $this->getModelNamespaces();
        foreach ($namespaces as $namespace => $path) {
            if (str_contains($namespace, $needle)) {
                $possibleModel = $namespace . '\\' . $model;
                if (class_exists($possibleModel) && is_subclass_of($possibleModel, ModelInterface::class)) {
                    return $possibleModel;
                }
            }
        }
        
        return null;
    }
    
    /**
     * Return the current controller short name
     */
    public function getControllerName(): string
    {
        return $this->dispatcher->getControllerName()
            ?: substr(basename(str_replace('\\', '/', get_class($this))), 0, -10);
    }
    
    /**
     * Load the model using the modelsManager
     * return a new model instance
     */
    public function loadModel(?string $modelName = null): ModelInterface
    {
        $modelName ??= $this->getModelName() ?? '';
        return $this->modelsManager->load($modelName);
    }
}
