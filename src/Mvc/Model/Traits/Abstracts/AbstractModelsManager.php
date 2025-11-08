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

namespace PhalconKit\Mvc\Model\Traits\Abstracts;

use Phalcon\Mvc\Model\ManagerInterface;

trait AbstractModelsManager
{
    use AbstractInjectable;
    
    abstract public function getModelsManager(): ManagerInterface;
}
