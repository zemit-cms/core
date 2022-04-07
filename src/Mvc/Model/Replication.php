<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model;

use Phalcon\Db\Adapter\Pdo\Mysql;

/**
 * Trait Replication
 * Replica Lag Workaround
 * Prevents Phalcon to use read connection while
 * it might be lagging behind the db master
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Mvc\Model
 */
trait Replication
{
    /**
     * Replica Lag in milliseconds
     * @var int|null
     */
    protected static ?int $_replicationLag = null;
    
    /**
     * Timestamp until we can use replication
     * @var int|null
     */
    protected static ?int $_replicationReadyAt = null;
    
    /**
     * Get the replication lag value in milliseconds
     */
    public static function getReplicationLag(): ?int
    {
        return self::$_replicationLag;
    }
    
    /**
     * Set the replication lag value in milliseconds
     *
     * @param int|null $replicationLag
     */
    public static function setReplicationLag(?int $replicationLag = null): void
    {
        self::$_replicationLag = $replicationLag;
    }
    
    /**
     * Get the replication lag value in milliseconds
     */
    public static function getReplicationReadyAt(): ?int
    {
        return self::$_replicationReadyAt;
    }
    
    /**
     * Set the replication lag value in milliseconds
     *
     * @param int|null $replicationReadyAt
     */
    public static function setReplicationReadyAt(?int $replicationReadyAt = null): void
    {
        self::$_replicationReadyAt = $replicationReadyAt;
    }
    
    /**
     * Replication Trait Initialization
     * - @todo get replica lag dynamically using raw SQL query if possible
     * - Set Read & Write Connection Service
     * - Add Replication Behavior
     */
    public function initializeReplication($force = false)
    {
        $di = $this->getDI();
        $enabled = $force || $di->config->path('database.drivers.mysql.readonly.enable', false);
        
        if ($enabled) {
            self::setReplicationLag(1000);
            $this->setConnectionService('db');
            $this->setReadConnectionService('dbr');
            $this->setWriteConnectionService('db');
            $this->addReadWriteConnectionBehavior();
        }
    }
    
    /**
     * Dynamically selects a shard
     * - Prefer to read on the write master during the replica delay
     *
     * @param array $intermediate
     * @param array $bindParams
     * @param array $bindTypes
     *
     * @return Mysql
     */
    public function selectReadConnection($intermediate, $bindParams, $bindTypes)
    {
        $di = $this->getDI();
        
        // Check if the replication is ready
        if ($this->isReplicationReady()) {
            
            // Use the read connection service
            $di->get($this->getReadConnectionService());
        }
        
        // Use the write connection service
        return $this->getDI()->get($this->getWriteConnectionService());
    }
    
    /**
     * Force the write connection service to master if the model was previously saved
     */
    public function addReadWriteConnectionBehavior(): void
    {
        $forceMasterConnectionService = function() {
            self::setReplicationReadyAt(round(microtime(true) * 1000) + self::REPLICA_DELAY);
        };
        $eventsManager = $this->getEventsManager();
        $eventsManager->attach('model:afterSave', $forceMasterConnectionService);
        $eventsManager->attach('model:afterCreate', $forceMasterConnectionService);
        $eventsManager->attach('model:afterUpdate', $forceMasterConnectionService);
        $eventsManager->attach('model:afterDelete', $forceMasterConnectionService);
        $eventsManager->attach('model:afterRestore', $forceMasterConnectionService);
    }
    
    /**
     * Check whether the replica should be ready or not
     *
     * @return bool true if replica should be ready
     */
    public function isReplicationReady(): bool
    {
        $replicationReadyAt = self::getReplicationReadyAt();
        if (empty($replicationReadyAt) || $replicationReadyAt < microtime(true) * 1000) {
            self::setReplicationReadyAt(null);
            
            return true;
        }
        
        return false;
    }
}
