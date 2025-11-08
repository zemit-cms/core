<?php

declare(strict_types=1);

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit Team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace PhalconKit\Bootstrap;

class Devtools extends Config
{
    public function __construct(array $data = [], bool $insensitive = true)
    {
        parent::__construct($data, $insensitive);
    
        $databaseConfig = $this->pathToArray('database');
        $driverName = $databaseConfig['default'] ?? 'mysql';
        $driverOptions = $databaseConfig['drivers'][$driverName] ?? [];
        $adapterClass = $driverOptions['adapter'] ?? null;
        
        if (!isset($adapterClass) || !is_string($adapterClass)) {
            throw new \InvalidArgumentException('A valid database adapter class must be provided.');
        }
    
        $driverOptions['adapter'] = basename(str_replace('\\', '/', $adapterClass));
        unset($driverOptions['readonly']);
        
        $this->set('database', $driverOptions);
    }
}
