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

use Phalcon\Di\DiInterface;

class WebSocket extends \Phalcon\Cli\Console
{
    public function __construct(?DiInterface $container = null)
    {
        parent::__construct($container);
    }
}
