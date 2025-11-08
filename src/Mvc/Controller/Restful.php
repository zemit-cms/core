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

namespace PhalconKit\Mvc\Controller;

use PhalconKit\Mvc\Controller\Traits\Actions\RestActions;
use PhalconKit\Mvc\Controller\Traits\Export;
use PhalconKit\Mvc\Controller\Traits\Expose;
use PhalconKit\Mvc\Controller\Traits\Model;
use PhalconKit\Mvc\Controller\Traits\Query;

class Restful extends Rest
{
    use RestActions;
    use Export;
    use Expose;
    use Model;
    use Query;
    
    /**
     * @return void
     */
    public function initialize()
    {
        $this->initializeQuery();
    }
}
