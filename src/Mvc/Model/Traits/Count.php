<?php

declare(strict_types=1);

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model\Traits;

use Phalcon\Di\Di;
use Phalcon\Mvc\Model\Query\Builder;
use Zemit\Mvc\Model\ManagerInterface;

/**
 * Trait Count
 */
trait Count
{
    public static function subCount(mixed $find): int
    {
        $find ??= [];
        $find = is_array($find) ? $find : [$find];
        
        // Get the models manager
        $modelsManager = Di::getDefault()->getShared('modelsManager');
        assert($modelsManager instanceof ManagerInterface);
        
        // Create a builder for the subquery
        $builder = $modelsManager->createBuilder($find)->from(get_called_class());
        
        // Get the raw SQL query and its bind parameters
        $querySql = $builder->getQuery()->getSQL();
        
        // Create the raw SQL query for the count
        $rawSql = "SELECT COUNT(*) AS total_count FROM ({$querySql['sql']}) as query_count";
        
        // Execute the raw SQL query
        $db = Di::getDefault()->get('db');  // Get the database service
        $result = $db->query($rawSql, $querySql['bind'], $querySql['bindTypes']);
        
        // Fetch the total count
        $row = $result->fetch();
        
        // Return the total count
        return (int)$row['total_count'];
    }
}
