<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model\EagerLoading;

use Phalcon\Mvc\Model\Relation;
use Phalcon\Mvc\Model\Resultset\Simple;
use Phalcon\Mvc\Model\ResultsetInterface;
use Phalcon\Mvc\ModelInterface;

final class Loader
{
    protected ?array $subject;
    
    protected string $className;
    
    protected array $eagerLoads;
    
    protected bool $singleModel;
    
    protected array $options = [];
    
    private const E_INVALID_SUBJECT = 'Expected value of `subject` to be either a ModelInterface object, a Simple object or an array of ModelInterface objects';
    
    /**
     * @throws \InvalidArgumentException
     */
    public function __construct($from, array ...$arguments)
    {
        $error = false;
        $className = null;
        $this->singleModel = false;
        
        // Handle Model Interface
        if ($from instanceof ModelInterface) {
            $className = get_class($from);
            $from = [$from];
            $this->singleModel = true;
        }
        
        // Handle Simple Resultset
        elseif ($from instanceof Simple) {
            $from = iterator_to_array($from);
            if (isset($from[0])) {
                $className ??= get_class($from[0]);
            }
            else {
                $from = null;
            }
        }
        
        // Handle array
        elseif (is_array($from)) {
            $from = array_filter($from);
            if (isset($from[0])) {
                $className ??= get_class($from[0]);
            }
            foreach ($from as $el) {
                if ($el instanceof ModelInterface) {
                    // elements must be all the same model class
                    if ($className !== get_class($el)) {
                        $error = true;
                        break;
                    }
                }
                else {
                    // element must be a ModelInterface
                    $error = true;
                    break;
                }
            }
            if (empty($from)) {
                $from = null;
            }
        }
        
        // Handle null or empty
        elseif (is_null($from) || is_bool($from)) {
            $from = null;
        }
        
        // error
        else {
            $error = true;
        }
        
        if ($error) {
            throw new \InvalidArgumentException(self::E_INVALID_SUBJECT);
        }
        
        $this->subject = $from;
        $this->className = $className;
        $this->eagerLoads = ($from === null || empty($arguments)) ? [] : self::parseArguments($arguments);
    }
    
    /**
     * Set Options
     */
    public function setOptions(array $options = []): self
    {
        $this->options = $options;
        return $this;
    }
    
    /**
     * Creates an instance of the current object from various input types and returns it.
     *
     * @param mixed $subject The input object or array to create the instance from.
     * @param mixed ...$arguments Additional arguments that can be passed to the creation process.
     * @return array|ModelInterface The current object instance created from the input.
     */
    public static function from(array|ModelInterface|ResultsetInterface $subject, mixed ...$arguments): array|ModelInterface
    {
        if ($subject instanceof ModelInterface) {
            return self::fromModel($subject, ...$arguments);
        }
        
        if ($subject instanceof ResultsetInterface) {
            return self::fromResultset($subject, ...$arguments);
        }
        
        return self::fromArray($subject, ...$arguments);
    }
    
    /**
     * Create and get from a Model
     *
     * @param ModelInterface $subject
     * @param mixed ...$arguments
     * @return ModelInterface
     */
    public static function fromModel(ModelInterface $subject, ...$arguments): ModelInterface
    {
        return (new self($subject, ...$arguments))->execute()->get();
    }
    
    /**
     * Create and get from a Model without soft deleted records
     *
     * @param ModelInterface $subject
     * @param mixed ...$arguments
     * @return ModelInterface
     */
    public static function fromModelWithoutSoftDelete(ModelInterface $subject, ...$arguments): ModelInterface
    {
        $options = ['softDelete' => 'softDelete'];
        $obj = new self($subject, ...$arguments);
        return $obj->setOptions($options)->execute()->get();
    }
    
    /**
     * Create and get from an array
     *
     * @param ModelInterface[] $subject
     * @param mixed ...$arguments
     * @return array
     */
    public static function fromArray(array $subject, ...$arguments): array
    {
        return (new self($subject, ...$arguments))->execute()->get();
    }
    
    /**
     * Create and get from an array without soft deleted records
     *
     * @param ModelInterface[] $subject
     * @param mixed ...$arguments
     * @return array
     */
    public static function fromArrayWithoutSoftDelete(array $subject, ...$arguments): array
    {
        $options = ['softDelete' => 'softDelete'];
        $obj = new self($subject, ...$arguments);
        return $obj->setOptions($options)->execute()->get();
    }
    
    /**
     * Create and get from a Resultset
     *
     * @param ResultsetInterface $subject
     * @param mixed ...$arguments
     * @return ?array
     */
    public static function fromResultset(ResultsetInterface $subject, ...$arguments): ?array
    {
        return (new self($subject, ...$arguments))->execute()->get();
    }
    
    /**
     * @return null|ModelInterface[]|ModelInterface
     */
    public function get()
    {
        return $this->singleModel
            ? $this->subject[0] ?? null
            : $this->subject ?? [];
    }
    
    /**
     * @return null|ModelInterface[]
     */
    public function getSubject()
    {
        return $this->subject;
    }
    
    /**
     * Parses the arguments that will be resolved to Relation instances
     *
     * @param array $arguments
     * @return array
     * @throws \InvalidArgumentException
     */
    private static function parseArguments(array $arguments)
    {
        if (empty($arguments)) {
            throw new \InvalidArgumentException('Arguments can not be empty');
        }
        
        $relations = [];
        if (count($arguments) === 1 && isset($arguments[0]) && is_array($arguments[0])) {
            foreach ($arguments[0] as $relationAlias => $queryConstraints) {
                if (is_string($relationAlias)) {
                    $relations[$relationAlias] = is_callable($queryConstraints) ? $queryConstraints : null;
                }
                elseif (is_string($queryConstraints)) {
                    $relations[$queryConstraints] = null;
                }
            }
        }
        else {
            foreach ($arguments as $relationAlias) {
                if (is_string($relationAlias)) {
                    $relations[$relationAlias] = null;
                }
            }
        }
        
        return $relations;
    }
    
    public function addEagerLoad(string $relationAlias, ?callable $constraints = null): self
    {
        $this->eagerLoads[$relationAlias] = $constraints;
        return $this;
    }
    
    /**
     * Resolves the relations
     *
     * @return EagerLoad[]
     * @throws \RuntimeException
     */
    private function buildTree()
    {
        uksort($this->eagerLoads, 'strcmp');
        
        $di = \Phalcon\DI\Di::getDefault();
        $mM = $di['modelsManager'];
        
        $eagerLoads = $resolvedRelations = [];
        
        foreach ($this->eagerLoads as $relationAliases => $queryConstraints) {
            $nestingLevel = 0;
            $relationAliases = explode('.', $relationAliases);
            $nestingLevels = count($relationAliases);
            
            do {
                do {
                    $alias = $relationAliases[$nestingLevel];
                    $name = implode('.', array_slice($relationAliases, 0, $nestingLevel + 1));
                }
                while (isset($eagerLoads[$name]) && ++$nestingLevel);
                
                if ($nestingLevel === 0) {
                    $parentClassName = $this->className;
                }
                else {
                    $parentName = implode('.', array_slice($relationAliases, 0, $nestingLevel));
                    $parentClassName = $resolvedRelations[$parentName]->getReferencedModel();
                    
                    if ($parentClassName[0] === '\\') {
                        $parentClassName = ltrim($parentClassName, '\\');
                    }
                }
                
                if (!isset($resolvedRelations[$name])) {
                    $mM->load($parentClassName);
                    $relation = $mM->getRelationByAlias($parentClassName, $alias);
                    
                    if (!$relation instanceof Relation) {
                        throw new \RuntimeException(sprintf(
                            'There is no defined relation for the model `%s` using alias `%s`',
                            $parentClassName,
                            $alias
                        ));
                    }
                    
                    $resolvedRelations[$name] = $relation;
                }
                else {
                    $relation = $resolvedRelations[$name];
                }
                
                $relType = $relation->getType();
                
                if ($relType !== Relation::BELONGS_TO &&
                    $relType !== Relation::HAS_ONE &&
                    $relType !== Relation::HAS_MANY &&
                    $relType !== Relation::HAS_MANY_THROUGH
                ) {
                    
                    throw new \RuntimeException(sprintf('Unknown relation type `%s`', $relType));
                }
                
                if (is_array($relation->getFields()) ||
                    is_array($relation->getReferencedFields())
                ) {
                    
                    throw new \RuntimeException('Relations with composite keys are not supported');
                }
                
                $parent = $nestingLevel > 0 && isset($parentName)? $eagerLoads[$parentName] : $this;
                $constraints = $nestingLevel + 1 === $nestingLevels ? $queryConstraints : null;
                
                $eagerLoads[$name] = new EagerLoad($relation, $constraints, $parent);
            }
            while (++$nestingLevel < $nestingLevels);
        }
        
        return $eagerLoads;
    }
    
    /**
     * Execute the eager loading of related models.
     *
     * This method iterates through the result of the buildTree method and loads the related models
     * using the load method of each eager load instance.
     *
     * @return self The instance of the class executing the method.
     */
    public function execute(): self
    {
        foreach ($this->buildTree() as $eagerLoad) {
            // @todo option to enable or disable soft delete etc.
//            $eagerLoad->load($this->options); 
            $eagerLoad->load();
        }
        
        return $this;
    }
    
    /**
     * Loads the data from a data source and returns an instance of the current object.
     *
     * @return $this The current object instance after loading the data.
     */
    public function load(): self
    {
        return $this->execute();
    }
}
