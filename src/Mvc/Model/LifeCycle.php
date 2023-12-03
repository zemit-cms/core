<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model;

use Phalcon\Db\Column;
use Phalcon\Di\Di;
use Phalcon\Mvc\Model\ManagerInterface;
use Phalcon\Mvc\Model\Query\Builder;
use Phalcon\Mvc\Model\QueryInterface;
use Phalcon\Mvc\Model\ResultsetInterface;
use Zemit\Mvc\Model;
use Zemit\Mvc\Model\AbstractTrait\AbstractEventsManager;
use Zemit\Mvc\Model\AbstractTrait\AbstractModelsManager;

trait LifeCycle
{
    use AbstractModelsManager;
    
    /**
     * Return the query for data retention
     */
    public static function prepareLifeCycleQuery(Builder $builder = null, ?array $parameters = null): void
    {
        // data life cycle policy must be defined
        if (empty($parameters)) {
            $builder->where('false');
            $builder->setBindParams([]);
            $builder->setBindTypes([]);
        }
    }
    
    public static function getLifeCyclePolicy(): array
    {
        $config = Di::getDefault()->get('config');
        $dataLifeCycleConfig = $config->pathToArray('dataLifeCycle');
        $policyName = $dataLifeCycleConfig['models'][self::class] ?? null;
        return $dataLifeCycleConfig['models'][$policyName] ?? [];
    }
    
    public static function getLifeCyclePolicyQuery(): ?array
    {
        return self::getLifeCyclePolicy()['query'] ?? null;
    }
    
    /**
     * Return the Query for data retention
     */
    public static function getLifeCycleQuery(?array $parameters = null, ?Builder $builder = null): QueryInterface
    {
        $parameters ??= self::getLifeCyclePolicyQuery();
        $builder ??= self::getBuilder($parameters);
        
        self::prepareLifeCycleQuery($builder, $parameters);
        
        return $builder->getQuery();
    }
    
    /**
     * Return a Query Builder based on parameters
     */
    public static function getBuilder(?array $parameters = null): Builder
    {
        $di = Di::getDefault();
        $modelsManager = $di->getShared('modelsManager');
        assert($modelsManager instanceof ManagerInterface);
        
        $builder = $modelsManager->createBuilder($parameters);
        $builder->from(get_called_class());
        
        if (isset($parameters['limit'])) {
            $builder->limit($parameters['limit']);
        }
        
        return $builder;
    }
    
    /**
     * Find records to hard delete for data retention purpose
     * @return mixed
     */
    public static function findLifeCycle(?array $parameters = null)
    {
        $query = self::getLifeCycleQuery($parameters);
        $resultset = $query->execute();
        
        if ($resultset instanceof ResultsetInterface) {
            if (isset($parameters['hydration'])) {
                $resultset->setHydrateMode($parameters['hydration']);
            }
        }
        
        return $resultset;
    }
}
