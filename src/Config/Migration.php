<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Config;

use Zemit\Bootstrap\Config as BootstrapConfig;

class Migration extends BootstrapConfig
{
    public function __construct(array $data = [], bool $insensitive = true)
    {
        parent::__construct($data, $insensitive);
        
        $driver = $this->path('database.default');
        $database = $this->path('database.drivers.' . $driver);
        $this->set('database', $database);
        $this->get('database')->remove('options');
        $this->get('database')->remove('readOnly');
    }
}

return new Migration();
