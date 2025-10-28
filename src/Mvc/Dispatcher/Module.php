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

namespace Zemit\Mvc\Dispatcher;

use Phalcon\Dispatcher\DispatcherInterface;
use Phalcon\Events\Event;
use Zemit\Di\Injectable;

class Module extends Injectable
{
    public function beforeForward(Event $event, DispatcherInterface $dispatcher, array $forward): void
    {
        if (!empty($forward['module'])) {
            $dispatcher->setModuleName($forward['module']);
            // @todo automatically add namepsace https://docs.phalcon.io/3.4/en/dispatcher#using-the-events-manager
        }
    }
}
