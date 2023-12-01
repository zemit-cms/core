<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\AbstractTrait;

use Zemit\Mvc\Model\AbstractTrait\AbstractInjectable;
use Zemit\Mvc\Model\Manager;

trait AbstractModelsManager
{
    use AbstractInjectable;
    
    /**
     * Get modelsManager service from DI
     */
    public function getModelsManager(): Manager
    {
        if (!$this->{'modelsManager'}) {
            $this->{'modelsManager'} = $this->getDI()->getShared('modelsManager');
        }
        
        return $this->{'modelsManager'};
    }
}
