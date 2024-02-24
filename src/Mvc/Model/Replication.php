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

use Phalcon\Config\ConfigInterface;
use Phalcon\Db\Adapter\AdapterInterface;
use Zemit\Mvc\Model\AbstractTrait\AbstractInjectable;

/**
 * Replica Lag Workaround
 * Prevents Phalcon to use read connection while
 * it might be lagging behind the master db
 */
trait Replication
{
    abstract public function setConnectionService(string $connectionService): void;
    abstract public function setReadConnectionService(string $connectionService): void;
    abstract public function setWriteConnectionService(string $connectionService): void;
    
    use AbstractInjectable;
    use Options;
    
    /**
     * Replica Lag in milliseconds
     */
    protected static ?int $replicationLag = null;
    
    /**
     * Timestamp until we can use replication
     */
    protected static ?int $replicationReadyAt = null;
    
    /**
     * Get the replication lag value in milliseconds
     */
    public static function getReplicationLag(): ?int
    {
        return self::$replicationLag;
    }
    
    /**
     * Set the replication lag value in milliseconds
     */
    public static function setReplicationLag(?int $replicationLag = null): void
    {
        self::$replicationLag = $replicationLag;
    }
    
    /**
     * Get the replication lag value in milliseconds
     */
    public static function getReplicationReadyAt(): ?int
    {
        return self::$replicationReadyAt;
    }
    
    /**
     * Set the replication lag value in milliseconds
     */
    public static function setReplicationReadyAt(?int $replicationReadyAt = null): void
    {
        self::$replicationReadyAt = $replicationReadyAt;
    }
    
    /**
     * Replication Trait Initialization
     * - Set Read & Write Connection Service
     * - Add Replication Behavior
     */
    public function initializeReplication(?array $options = null): void
    {
        $options ??= $this->getOptionsManager()->get('replication') ?? [];
        
        $config = $this->getDI()->get('config');
        assert($config instanceof ConfigInterface);
        
        $enabled = $config->path('database.drivers.mysql.readonly.enable', false);
        if ($enabled) {
            self::setReplicationLag($options['lag'] ?? 1000);
            $this->setConnectionService($options['connectionService'] ?? 'db');
            $this->setReadConnectionService($options['readConnectionService'] ?? 'dbr');
            $this->setWriteConnectionService($options['writeConnectionService'] ?? 'db');
            $this->addReadWriteConnectionBehavior();
        }
    }
    
    /**
     * Dynamically selects a shard
     * - Prefer to read on the write master during the replica delay
     * 
     * Possible parameters which can be added if required
     * ?array $intermediate = null, array $bindParams = [], array $bindTypes = []
     * 
     * @return AdapterInterface
     */
    public function selectReadConnection(): AdapterInterface
    {
        $di = $this->getDI();
        
        // Check if the replication is ready
        if ($this->isReplicationReady()) {
            
            // Use the read connection service
            $di->get($this->getReadConnectionService());
        }
        
        // Use write connection service
        return $this->getDI()->get($this->getWriteConnectionService());
    }
    
    /**
     * Force write connection service to master if the model was previously saved
     */
    public function addReadWriteConnectionBehavior(): void
    {
        $forceMasterConnectionService = function () {
            self::setReplicationReadyAt(round(microtime(true) * 1000) + self::getReplicationLag());
        };
        
        // @todo change to behavior or check if this is added multiple times
        $eventsManager = $this->getEventsManager();
        $eventsManager->attach('model:afterSave', $forceMasterConnectionService);
        $eventsManager->attach('model:afterCreate', $forceMasterConnectionService);
        $eventsManager->attach('model:afterUpdate', $forceMasterConnectionService);
        $eventsManager->attach('model:afterDelete', $forceMasterConnectionService);
        $eventsManager->attach('model:afterRestore', $forceMasterConnectionService);
    }
    
    /**
     * Check whether the replica should be ready or not
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
