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
use Zemit\Di\Injectable;
use Phalcon\Events\EventInterface;

/**
 * Class Profiler
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Db\Events
 */
class Profiler extends Injectable
{
    /**
     * Check if the profiler is currently enabled or not from the config
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return (bool)$this->config->path('app.profiler',
            $this->config->path('profiler.enable',
                false
            )
        );
    }
    
    /**
     * Start the current profile if profiler is enable
     *
     * @param EventInterface $event
     * @param AbstractAdapter $connection
     */
    public function beforeQuery(EventInterface $event, AbstractAdapter $connection)
    {
        if ($this->isEnabled()) {
            if (!$event->isStopped()) {
                $this->profiler->startProfile(
                    $connection->getSQLStatement(),
                    $connection->getSqlVariables(),
                    $connection->getSQLBindTypes(),
                );
            }
        }
    }
    
    /**
     * Stop the current profile
     *
     * @scrutinizer ignore-unused
     *
     * @param EventInterface $event
     * @param AbstractAdapter $connection
     */
    public function afterQuery(EventInterface $event, AbstractAdapter $connection)
    {
        if ($this->isEnabled()) {
            $this->profiler->stopProfile();
        }
    }
}
