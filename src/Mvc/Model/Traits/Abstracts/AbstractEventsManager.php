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

use Phalcon\Events\ManagerInterface;

trait AbstractEventsManager
{
    use AbstractInjectable;
    
    abstract public function getEventsManager(): ?ManagerInterface;
    
    abstract public function fireEventCancel(string $eventName): bool;
    
    abstract public function fireEvent(string $eventName): bool;
}
