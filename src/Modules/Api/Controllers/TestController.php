<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Modules\Api\Controllers;

use Zemit\Modules\Api\Controller;
use Zemit\Support\Utils;

class TestController extends Controller
{
    public function memoryAction()
    {
        return Utils::getMemoryUsage();
    }
}
