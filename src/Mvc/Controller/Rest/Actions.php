<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Rest;

use Zemit\Mvc\Controller\Rest\Actions\CountAction;
use Zemit\Mvc\Controller\Rest\Actions\DeleteAction;
use Zemit\Mvc\Controller\Rest\Actions\ExportAction;
use Zemit\Mvc\Controller\Rest\Actions\GetAction;
use Zemit\Mvc\Controller\Rest\Actions\GetListAction;
use Zemit\Mvc\Controller\Rest\Actions\IndexAction;
use Zemit\Mvc\Controller\Rest\Actions\NewAction;
use Zemit\Mvc\Controller\Rest\Actions\ReorderAction;
use Zemit\Mvc\Controller\Rest\Actions\RestoreAction;
use Zemit\Mvc\Controller\Rest\Actions\SaveAction;

trait Actions
{
    use CountAction;
    use DeleteAction;
    use ExportAction;
    use GetAction;
    use GetListAction;
    use IndexAction;
    use NewAction;
    use ReorderAction;
    use RestoreAction;
    use SaveAction;
}
