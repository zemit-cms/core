<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc;

use Zemit\Dispatcher\DispatcherInterface;
use Zemit\Dispatcher\DispatcherTrait;

/**
 * {@inheritDoc}
 */
class Dispatcher extends \Phalcon\Mvc\Dispatcher implements DispatcherInterface
{
    use DispatcherTrait;
}
