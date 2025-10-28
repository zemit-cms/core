<?php

declare(strict_types=1);

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Traits\Actions;

use Zemit\Mvc\Controller\Traits\Actions\Rest\AverageAction;
use Zemit\Mvc\Controller\Traits\Actions\Rest\CountAction;
use Zemit\Mvc\Controller\Traits\Actions\Rest\DeleteAction;
use Zemit\Mvc\Controller\Traits\Actions\Rest\DistinctAction;
use Zemit\Mvc\Controller\Traits\Actions\Rest\ExportAction;
use Zemit\Mvc\Controller\Traits\Actions\Rest\FindAction;
use Zemit\Mvc\Controller\Traits\Actions\Rest\FindFirstAction;
use Zemit\Mvc\Controller\Traits\Actions\Rest\IndexAction;
use Zemit\Mvc\Controller\Traits\Actions\Rest\MaximumAction;
use Zemit\Mvc\Controller\Traits\Actions\Rest\MinimumAction;
use Zemit\Mvc\Controller\Traits\Actions\Rest\NewAction;
use Zemit\Mvc\Controller\Traits\Actions\Rest\ReorderAction;
use Zemit\Mvc\Controller\Traits\Actions\Rest\RestoreAction;
use Zemit\Mvc\Controller\Traits\Actions\Rest\SaveAction;
use Zemit\Mvc\Controller\Traits\Actions\Rest\SumAction;

trait RestActions
{
    use AverageAction;
    use CountAction;
    use DeleteAction;
    use DistinctAction;
    use ExportAction;
    use FindAction;
    use FindFirstAction;
    use IndexAction;
    use MaximumAction;
    use MinimumAction;
    use NewAction;
    use ReorderAction;
    use RestoreAction;
    use SaveAction;
    use SumAction;
}
