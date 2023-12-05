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
use Phalcon\Autoload\Loader;

trait AbstractLoader
{
    use AbstractInjectable;
    
    /**
     * Get loader service from DI
     */
    public function getLoader(): Loader
    {
        if (!$this->{'loader'}) {
            $this->{'loader'} = $this->getDI()->getShared('loader');
        }
        
        return $this->{'loader'};
    }
}
