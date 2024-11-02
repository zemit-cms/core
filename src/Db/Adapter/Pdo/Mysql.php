<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Db\Adapter\Pdo;

use Phalcon\Db\Column;

class Mysql extends \Phalcon\Db\Adapter\Pdo\Mysql
{
    public function describeColumns(string $table, string $schema = null): array
    {
        $definitions = parent::describeColumns($table, $schema);
        
        // @todo see if we can remove this and reactivate phpstan
        // @phpstan-ignore-next-line
        if (Column::TYPE_TINYINTEGER !== Column::TYPE_BINARY) {
            return $definitions;
        }
        
        // @phpstan-ignore-next-line
        foreach ($definitions as $definitionKey => $definition) {
            
            if ($definition->getType() === Column::TYPE_TINYINTEGER && !$definition->isNumeric()) {
                // probably a binary at this point
                
                $newDefinition = [];
                
                // protected to public
                $prefix = chr(0) . '*' . chr(0);
                foreach ((array)$definition as $key => $value) {
                    $newDefinition[str_replace($prefix, '', $key)] = $value;
                }
                
                $newDefinition['bindType'] = Column::BIND_PARAM_BLOB;
                $newDefinition['type'] = Column::TYPE_VARBINARY;
                unset($newDefinition['scale']);
                
                /**
                 * reset definition
                 * @psalm-suppress InvalidArgument
                 */
                $definitions[$definitionKey] = new Column($definition->getName(), $newDefinition);
            }
        }
        
        return $definitions;
    }
}
