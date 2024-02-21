<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Acl;

use Phalcon\Acl\Adapter\Memory;

interface AclInterface {
    
    public function get(array $componentsName = ['components'], ?array $permissions = null, string $inherit = 'inherit'): Memory;
    
}
