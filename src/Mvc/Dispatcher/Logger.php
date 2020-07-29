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

use Phalcon\Acl\Resource;
use Phalcon\Dispatcher\AbstractDispatcher;
use Phalcon\Events\Event;
use Phalcon\Mvc\ModelInterface;
use Zemit\Di\Injectable;
use Zemit\Events\Identity;
use Zemit\Mvc\Dispatcher;

/**
 * SecurityPlugin
 *
 * This is the security plugin which controls that users only have access to the modules they're assigned to
 */
class Logger extends Injectable
{
    /**
     * Check if the logger is currently enabled or not from the config
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return (
                $this->config->has('app') &&
                $this->config->get('app')->logger
            ) || (
                $this->config->has('logger') &&
                $this->config->get('logger')->enable
            );
    }
    
    /**
     * This action is executed before execute any action in the application
     * Keeping a log of the dispatch event
     *
     * @param Event $event
     * @param \Phalcon\Mvc\Dispatcher|\Zemit\Mvc\Dispatcher $dispatcher
     */
    public function beforeDispatchLoop(Event $event, AbstractDispatcher $dispatcher)
    {
        if ($this->isEnabled()) {
            
            if ($this->config->has('logger') &&
                $this->config->get('logger')->dispatcher) {
                
                /** @var ModelInterface $session */
                $session = $this->identity->getSession();
                $sessionId = $session ? $session->readAttribute('id') : null;
                $userId = $this->identity->getUserId(false) ? : null;
                $userIdAs = $this->identity->getUserId(true) ? : null;
                
                $log = json_encode([
                    'type' => 'dispatch',
                    'sessionId' => $sessionId,
                    'userId' => $userId,
                    'userIdAs' => $userIdAs,
                    'meta' => [
                        'dispatch' => $dispatcher->toArray(),
                    ],
                ]);
                
                $this->logger->info($log);
            }
        }
    }
}
