<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Bootstrap;

class Devtools extends Config
{
    public function __construct(array $data = [], bool $insensitive = true)
    {
        parent::__construct($data, $insensitive);
    
        $databaseConfig = $this->pathToArray('database');
        $driverName = $databaseConfig['default'] ?? 'mysql';
        $driverOptions = $databaseConfig['drivers'][$driverName];
    
        $driverOptions['adapter'] = basename(str_replace('\\', '/', ($driverOptions['adapter'])));
        unset($driverOptions['readonly']);
//        unset($driverOptions['options']);
        
        $this->set('database', $driverOptions);
    }
}
