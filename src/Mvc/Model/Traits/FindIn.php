<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model\Traits;

use Phalcon\Db\Column;

/**
 * @todo
 * - findIn
 * - FindInBy...
 * - findFirstIn
 * - findFirstInBy...
 */
trait FindIn
{
    public static function findInById(array $idList = [])
    {
        $castInt = function ($id) {
            return (int)$id;
        };
        
        $idList = array_unique(array_filter(array_map($castInt, $idList)));
        $idList = empty($idList) ? [null] : $idList;
        
        $bindParam = '_id' . uniqid('_', true) . '_';
        
        return self::find([
            '[id] in ({'.$bindParam.':array})',
            'bind' => [$bindParam => $idList],
            'bindTypes' => [$bindParam => Column::BIND_PARAM_INT]
        ]);
    }
}
