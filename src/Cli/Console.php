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

use Phalcon\Di\DiInterface;

/**
 * Class Console
 * @package Zemit\Cli
 */
class Console extends \Phalcon\Cli\Console
{
    public function __construct(DiInterface $dependencyInjector = null)
    {
        parent::__construct($dependencyInjector);
    }
}
