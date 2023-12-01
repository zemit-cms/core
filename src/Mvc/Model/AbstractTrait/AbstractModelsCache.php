<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model\AbstractTrait;

use Phalcon\Cache;

trait AbstractModelsCache
{
    use AbstractInjectable;
    
    /**
     * Get modelsCache service from DI
     */
    public function getModelsCache(): Cache
    {
        return $this->getDI()->get('modelsCache');
    }
}
