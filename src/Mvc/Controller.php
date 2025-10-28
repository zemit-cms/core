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

namespace Zemit\Mvc;

use Zemit\Di\InjectableProperties;

/**
 * Class Controller
 *
 * @property \Zemit\Mvc\Dispatcher $dispatcher
 * @property \Zemit\Mvc\Router $router
 * @property \Zemit\Mvc\Application $application
 */
class Controller extends \Phalcon\Mvc\Controller
{
    use InjectableProperties;
}
