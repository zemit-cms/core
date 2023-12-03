<?php

namespace Zemit\Mvc\Controller\Rest;

use Phalcon\Mvc\ModelInterface;
use Zemit\Support\Helper;
use Zemit\Mvc\Controller\AbstractTrait\AbstractDispatcher;
use Zemit\Mvc\Controller\AbstractTrait\AbstractInjectable;
use Zemit\Mvc\Controller\AbstractTrait\AbstractLoader;
use Zemit\Mvc\Controller\AbstractTrait\AbstractModelsManager;
use Zemit\Mvc\Controller\AbstractTrait\AbstractRouter;

trait ModelName
{
    use AbstractInjectable;
    use AbstractLoader;
    use AbstractDispatcher;
    use AbstractRouter;
    use AbstractModelsManager;
    
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
            $this->modelNamespaces = $this->getLoader()->getNamespaces();
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
    public function getModelNameFromController(?array $namespaces = null, ?string $needle = 'Models'): ?string
    {
        $model = ucfirst(Helper::camelize(Helper::uncamelize($this->getControllerName())));
        
        if (class_exists($model)) {
            return $model;
        }
        
        $namespaces ??= $this->getModelNamespaces();
        foreach ($namespaces as $namespace => $path) {
            if (strpos($namespace, $needle) !== false) {
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
        return $this->getDispatcher()->getControllerName()
            ?: substr(basename(str_replace('\\', '/', get_class($this))), 0, -10);
    }
    
    /**
     * Load the model using the modelsManager
     * return a new model instance
     */
    public function loadModel(?string $modelName = null): ModelInterface
    {
        $modelName ??= $this->getModelName();
        return $this->getModelsManager()->load($modelName);
    }
}
