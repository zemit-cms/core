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
use Phalcon\Logger\Adapter\File as LoggerAdapter;
use Phalcon\Mvc\ModelInterface;
use Zemit\Di\Injectable;

/**
 * Class Logger
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Db\Events
 */
class Logger extends Injectable
{
    public $inProgress = false;
    
    /**
     * @param EventInterface $event
     * @param AbstractAdapter $connection
     */
    public function beforeQuery(EventInterface $event, AbstractAdapter $connection)
    {
        if ($this->config->logger->enable || $this->config->app->logger) {
    
            if ($this->config->logger->logDatabaseQuery) {
    
                if (!$this->inProgress) {
                    
                    // deactivate logger
                    $this->inProgress = true;
        
                    /** @var ModelInterface $session */
                    $session = $this->identity->getSession();
                    $sessionId = $session ? $session->readAttribute('id') : null;
                    $userId = $this->identity->getUserId(false) ?: null;
                    $userIdAs = $this->identity->getUserId(true) ?: null;
                    
                    $log = json_encode([
                        'type' => 'query',
                        'sessionId' => $sessionId,
                        'userId' => $userId,
                        'userIdAs' => $userIdAs,
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
