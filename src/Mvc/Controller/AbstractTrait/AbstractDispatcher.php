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

use Zemit\Mvc\Dispatcher;
use Zemit\Mvc\Model\AbstractTrait\AbstractInjectable;

trait AbstractDispatcher
{
    use AbstractInjectable;
    
    /**
     * Get dispatcher service from DI
     */
    public function getDispatcher(): Dispatcher
    {
        if (!$this->{'dispatcher'}) {
            $this->{'dispatcher'} = $this->getDI()->getShared('dispatcher');
        }
        
        return $this->{'dispatcher'};
    }
}
