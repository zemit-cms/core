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

namespace Zemit\Db\Events;

use Phalcon\Db\Adapter\AbstractAdapter;
use Phalcon\Events\EventInterface;
use Phalcon\Logger\Exception;
use Zemit\Di\Injectable;

/**
 * Responsible for logging database query events.
 */
class Logger extends Injectable
{
    public bool $inProgress = false;
    
    /**
     * Executes before a database query is executed.
     *
     * @param EventInterface $event The event object.
     * @param AbstractAdapter $connection The database connection object.
     * @return void
     * @throws Exception|\Exception If an error occurs while logging.
     */
    public function beforeQuery(EventInterface $event, AbstractAdapter $connection): void
    {
        if ($this->config->path('logger.enable') || $this->config->path('app.logger')) {
            if ($this->config->path('loggers.database.enable')) {
                if (!$this->inProgress) {
                    $this->inProgress = true;
//                    $sessionId = $this->identity->getSession()?->getId();
                    $userId = $this->identity->getUserId() ?: null;
                    $userAsId = $this->identity->getUserAsId() ?: null;
                    
                    $log = json_encode([
                        'type' => 'query',
                        'userId' => $userId,
                        'userAsId' => $userAsId,
                        'event' => [
                            'type' => $event->getType(),
                            'data' => $event->getData(),
                        ],
                        'meta' => [
                            'sqlStatement' => $connection->getSQLStatement(),
                            'sqlVariables' => $connection->getSQLVariables(),
                        ],
                    ]);
                    
                    if (!empty($log)) {
                        $this->loggers->get('database')->info($log);
                    }
                    
                    $this->inProgress = false;
                }
            }
        }
    }
}
