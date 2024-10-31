<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller;

use Zemit\Mvc\Controller\Traits\Actions\RestActions;
use Zemit\Mvc\Controller\Traits\Export;
use Zemit\Mvc\Controller\Traits\Expose;
use Zemit\Mvc\Controller\Traits\Model;
use Zemit\Mvc\Controller\Traits\Query;

class Restful extends Rest
{
    use RestActions;
    use Export;
    use Expose;
    use Model;
    use Query;
    
    public function initialize() {
        $this->initializeQuery();
    }
}
