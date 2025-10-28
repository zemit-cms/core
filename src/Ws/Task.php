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

namespace Zemit\Ws;

use Zemit\Di\InjectableProperties;

/**
 * @property \Zemit\Ws\WebSocket $webSocket
 * @property \Zemit\Ws\Router $router
 * @property \Zemit\Ws\Dispatcher $dispatcher
 */
class Task extends \Phalcon\Cli\Task implements TaskInterface
{
    use InjectableProperties;
}
