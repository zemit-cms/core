<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model\Behavior;

use Closure;
use Phalcon\Mvc\Model\Behavior\Exception;
use Phalcon\Mvc\Model\MetaData;
use Phalcon\Mvc\ModelInterface;
use Phalcon\Mvc\Model\Behavior;
use Zemit\Models\Audit;
use Zemit\Models\AuditDetail;
use Zemit\Mvc\Model\User;

/**
 * Zemit\Mvc\Model\Behavior\Blameable
 *
 * Allows to automatically update a model’s attribute saving the datetime when a
 * record is created or updated
 */
class Blameable extends Behavior
{
    /**
     * @var null
     */
    protected static $parentId = null;
    
    /**
     * @var array
     */
    protected $snapshot = null;
    
    /**
     * @var array
     */
    protected $changedFields = null;
    
    /**
     * @var string
     */
    protected $auditClass = Audit::class;
    
    /**
     * @var string
     */
    protected $auditDetailClass = AuditDetail::class;
    
    /**
     * @var string
     */
    protected $userClass = User::class;
    
    /**
     * Blameable constructor.
     *
     * @param array|null $options
     *
     * @throws Exception
     */
    public function __construct($options = null)
    {
        parent::__construct($options);
        
        $this->userClass = $options['userClass'] ?? $this->userClass;
        $this->auditClass = $options['auditClass'] ?? $this->auditClass;
        $this->auditDetailClass = $options['auditDetailClass'] ?? $this->auditDetailClass;
    }
    
    /**
     * {@inheritdoc}
     *
     * @param string $eventType
     * @param \Phalcon\Mvc\ModelInterface $model
     */
    public function notify($eventType, ModelInterface $model)
    {
        // prevent auditing audit & audit_detail tables
        if ($model instanceof $this->auditClass || $model instanceof $this->auditDetailClass) {
            return true;
        }
        
        switch ($eventType) {
            case 'afterCreate':
            case 'afterUpdate':
                return $this->createAudit($eventType, $model);
                break;
            case 'beforeUpdate':
                return $this->collectData($eventType, $model);
                break;
        }
    }
    
    /**
     * Audits an DELETE operation
     *
     * @param \Phalcon\Mvc\ModelInterface $model
     *
     * @return boolean
     */
    public function createAudit($event, ModelInterface $model)
    {
        $auditClass = $this->auditClass;
        $auditDetailClass = $this->auditDetailClass;
        
        /** @var MetaData $metaData */
        $metaData = $model->getModelsMetaData();
        $columns = $metaData->getAttributes($model);
        $columnMap = $metaData->getColumnMap($model);
        $changedFields = $this->changedFields;
        $snapshot = $this->snapshot;
        
        /** @var Audit $audit */
        $audit = new $auditClass();
        
        $audit->setModel(get_class($model));
        $audit->setTable($model->getSource());
        $audit->setPrimary($model->getId());
        $audit->setEvent($event);
        $audit->setColumns(json_encode($columnMap ? : $columns));
        $audit->setBefore($snapshot? json_encode($snapshot) : null);
        $audit->setAfter(json_encode($model->toArray()));
        $audit->setParentId(self::$parentId);
        
        $auditDetailList = [];
        foreach ($columns as $column) {
            $map = empty($columnMap) ? $column : $columnMap[$column];
            $before = $snapshot[$map] ?? null;
            $after = $model->readAttribute($map);
            
            // skip unchanged
            if ($event === 'afterUpdate' && $changedFields !== null && $snapshot !== null) {
                if ($before === $after || !in_array($map, $changedFields, true)) {
                    continue;
                }
            }
            
            /** @var AuditDetail $auditDetail */
            $auditDetail = new $auditDetailClass();
            
            $auditDetail->setModel(get_class($model));
            $auditDetail->setTable($model->getSource());
            $auditDetail->setPrimary($model->getId());
            $auditDetail->setEvent($event);
            $auditDetail->setColumn($column);
            $auditDetail->setMap($map);
            $auditDetail->setBefore($before);
            $auditDetail->setAfter($after);
            
            $auditDetailList[] = $auditDetail;
        }
        
        $audit->AuditDetailList = $auditDetailList;
        
        $save = $audit->save();
        foreach ($audit->getMessages() as $message) {
            $message->setField('Audit.' . $message->getField());
            $model->appendMessage($message);
        }
        
        self::$parentId = (!empty($model->hasDirtyRelated()))? $audit->getId() : null;
        
        return $save;
    }
    
    /**
     * @param ModelInterface $model
     */
    protected function collectData($event, ModelInterface $model)
    {
        if ($model->hasSnapshotData()) {
            $this->snapshot = $model->getSnapshotData();
            $this->changedFields = $model->getChangedFields();
        }
    }
}
