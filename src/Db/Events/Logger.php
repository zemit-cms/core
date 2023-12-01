<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Db\Events;

use Phalcon\Db\Adapter\AbstractAdapter;
use Phalcon\Events\EventInterface;
use Phalcon\Mvc\ModelInterface;
use Zemit\Di\Injectable;

/**
 * @todo review
 */
class Logger extends Injectable
{
    public bool $inProgress = false;
    
    public function beforeQuery(EventInterface $event, AbstractAdapter $connection): void
    {
        if ($this->config->path('logger.enable') || $this->config->path('app.logger')) {
            if ($this->config->path('logger.logDatabaseQuery')) {
                if (!$this->inProgress) {
                    
                    // deactivate logger
                    $this->inProgress = true;
    
                    $session = $this->identity->getSession();
                    assert($session instanceof ModelInterface);
                    
                    $sessionId = $session->readAttribute('id');
                    $userId = $this->identity->getUserId() ?: null;
                    $userAsId = $this->identity->getUserAsId() ?: null;
                    
                    $log = json_encode([
                        'type' => 'query',
                        'sessionId' => $sessionId,
                        'userId' => $userId,
                        'userAsId' => $userAsId,
                        'meta' => [
//                            'identity' => $this->identity->getIdentity(),
                            'sqlStatement' => $connection->getSQLStatement(),
                            'sqlVariables' => $connection->getSqlVariables(),
                        ],
                    ]);
                    
                    $this->logger->info($log);
                    
                    // reactivate logger
                    $this->inProgress = false;
                }
            }
        }
    }
}
