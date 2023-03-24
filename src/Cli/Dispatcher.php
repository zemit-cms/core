<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Cli;

use Zemit\Dispatcher\DispatcherInterface;
use Zemit\Dispatcher\DispatcherTrait;

class Dispatcher extends \Phalcon\Cli\Dispatcher implements DispatcherInterface
{
    use DispatcherTrait;
}
