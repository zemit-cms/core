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
use Zemit\Mvc\Dispatcher;

trait AbstractRouter
{
    use AbstractInjectable;
    
    /**
     * Get router service from DI
     */
    public function getRouter(): Dispatcher
    {
        if (!$this->{'router'}) {
            $this->{'router'} = $this->getDI()->getShared('router');
        }
        
        return $this->{'router'};
    }
}
