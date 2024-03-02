<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model\Traits\Abstracts;

use Phalcon\Events\ManagerInterface;

trait AbstractEventsManager
{
    use AbstractInjectable;
    
    abstract public function getEventsManager(): ?ManagerInterface;
    
    abstract public function fireEventCancel(string $eventName): bool;
    
    abstract public function fireEvent(string $eventName): bool;
}
