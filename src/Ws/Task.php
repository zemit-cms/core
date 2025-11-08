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

namespace PhalconKit\Ws;

use PhalconKit\Di\InjectableProperties;

/**
 * @property \PhalconKit\Ws\WebSocket $webSocket
 * @property \PhalconKit\Ws\Router $router
 * @property \PhalconKit\Ws\Dispatcher $dispatcher
 */
class Task extends \Phalcon\Cli\Task implements TaskInterface
{
    use InjectableProperties;
}
