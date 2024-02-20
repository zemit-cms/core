<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Models;

use Phalcon\Db\RawValue;
use Zemit\Models\Abstracts\AbstractTable;
use Zemit\Models\Interfaces\TableInterface;

class Table extends AbstractTable implements TableInterface
{
    protected $deleted = self::NO;

    public function initialize(): void
    {
        parent::initialize();
        
        $this->hasMany('id', Field::class, 'tableId', ['alias' => 'Fields']);
    }

    public function validation(): bool
    {
        $validator = $this->genericValidation();

        return $this->validate($validator);
    }
    
//    public static function find($parameters = null) : \Phalcon\Mvc\Model\ResultsetInterface{
//        $parameters['columns'] = '*, BIN_TO_UUID(uuid) AS uuid';
//        return parent::find($parameters);
//    }
}
