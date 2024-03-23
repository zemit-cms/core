<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Dispatcher;

use Phalcon\Events\Event;
use Phalcon\Logger\Exception;
use Zemit\Di\Injectable;
use Zemit\Dispatcher\DispatcherInterface;

class Logger extends Injectable
{
    /**
     * Check if the logger is currently enabled or not from the config
     */
    public function isEnabled(): bool
    {
        return ($this->config->path('app.logger') || $this->config->path('logger.enable'))
            && $this->config->path('logger.dispatcher');
    }
    
    /**
     * This action is executed before execute any action in the application
     * Keeping a log of the dispatch event
     * @throws Exception
     */
    public function beforeDispatchLoop(Event $event, DispatcherInterface $dispatcher): void
    {
        if ($this->isEnabled()) {
            if ($this->config->path('logger.dispatcher')) {
                $log = json_encode([
                    'type' => 'dispatch',
                    'sessionId' => $this->identity->getSessionId(),
                    'userId' => $this->identity->getUserId(),
                    'userAsId' => $this->identity->getUserAsId(),
                    'meta' => [
                        'dispatcher' => $dispatcher->toArray(),
                    ],
                ]);
                
                $this->logger->info($log);
            }
        }
    }
}
