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

use Phalcon\Di\InjectionAwareInterface;
use Phalcon\Mvc\Model\Query\Builder;
use Phalcon\Mvc\Model\Query\BuilderInterface;

final class QueryBuilder extends Builder implements BuilderInterface, InjectionAwareInterface
{
    const E_NOT_ALLOWED_METHOD_CALL = 'When eager loading relations queries must return full entities';
    
    /**
     * @param mixed $distinct
     * @throws \LogicException
     * @return BuilderInterface
     */
    public function distinct($distinct) : BuilderInterface
    {
        throw new \LogicException(static::E_NOT_ALLOWED_METHOD_CALL);
    }
    
    /**
     * @param array|mixed|string $columns
     * @throws \LogicException
     * @return BuilderInterface
     */
    public function columns($columns) : BuilderInterface
    {
        throw new \LogicException(static::E_NOT_ALLOWED_METHOD_CALL);
    }
    
    /**
     * @inheritDoc Builder
     * @param string $conditions
     * @param null $bindParams
     * @param null $bindTypes
     *
     * @return BuilderInterface
     */
    public function where(string $conditions, array $bindParams = [], array $bindTypes = []) : BuilderInterface
    {
        /**
         * Nest the condition to current ones or set as unique
         */
        if ($this->conditions) {
            $conditions = "(" . $this->conditions . ") AND (" . $conditions . ")";
        }
        
        return parent::where($conditions, $bindParams, $bindTypes);
    }
}
