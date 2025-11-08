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

namespace PhalconKit\Cli;

use PhalconKit\Di\InjectableProperties;

/**
 * @property \PhalconKit\Cli\Console $console
 * @property \PhalconKit\Cli\Router $router
 * @property \PhalconKit\Cli\Dispatcher $dispatcher
 */
class Task extends \Phalcon\Cli\Task implements TaskInterface
{
    use InjectableProperties;
}
