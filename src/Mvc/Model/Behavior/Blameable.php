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

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior;
use Phalcon\Mvc\ModelInterface;
use Zemit\Models\Audit;
use Zemit\Models\AuditDetail;
use Zemit\Models\Interfaces\AuditDetailInterface;
use Zemit\Models\Interfaces\AuditInterface;
use Zemit\Models\User;
use Zemit\Support\Helper;

/**
 * Zemit\Mvc\Model\Behavior\Blameable
 *
 * Allows to automatically update a model’s attribute saving the datetime when a
 * record is created or updated
 */
class Blameable extends Behavior
{
    use SkippableTrait;
    
    protected static ?int $parentId = null;

    protected ?array $snapshot = null;

    protected ?array $changedFields = null;
    
    protected string $auditClass = Audit::class;

    protected string $auditDetailClass = AuditDetail::class;

    protected string $userClass = User::class;
    
    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $this->userClass = $options['userClass'] ?? $this->userClass;
        $this->auditClass = $options['auditClass'] ?? $this->auditClass;
        $this->auditDetailClass = $options['auditDetailClass'] ?? $this->auditDetailClass;
    }
    
    public function notify(string $type, ModelInterface $model)
    {
        if ($this->isEnabled()) {
            return null;
        }
        
        // prevent auditing audit & audit_detail tables
        if ($model instanceof $this->auditClass || $model instanceof $this->auditDetailClass) {
            return null;
        }
        
        switch ($type) {
            case 'afterCreate':
            case 'afterUpdate':
                return $this->createAudit($type, $model);
            case 'beforeUpdate':
                return $this->collectData($model);
        }
    }
    
    /**
     * Create new audit
     * Return true if the audit was created
     */
    public function createAudit(string $type, Model $model): bool
    {
        $event = lcfirst(Helper::uncamelize(str_replace(['before', 'after'], ['', ''], $type)));
        
        $auditClass = $this->auditClass;
        $auditDetailClass = $this->auditDetailClass;
        
        $metaData = $model->getModelsMetaData();
        $columns = $metaData->getAttributes($model);
        $columnMap = $metaData->getColumnMap($model);
        $changedFields = $this->changedFields;
        $snapshot = $this->snapshot;
        
        $audit = new $auditClass();
        assert($audit instanceof AuditInterface);
        assert($audit instanceof Model);
        
        $audit->setModel(get_class($model));
        $audit->setTable($model->getSource());
        $audit->setPrimary($model->getId());
        $audit->setEvent($event);
        $audit->setColumns(json_encode($columnMap ?: $columns));
        $audit->setBefore($snapshot ? json_encode($snapshot) : null);
        $audit->setAfter(json_encode($model->toArray()));
        $audit->setParentId(self::$parentId);
        
        $auditDetailList = [];
        
        foreach ($columns as $column) {
            $map = empty($columnMap) ? $column : $columnMap[$column];
            $before = $snapshot[$map] ?? null;
            $after = $model->readAttribute($map);
            
            // skip unchanged
            if ($event === 'update' && $changedFields !== null && $snapshot !== null) {
                if ($before === $after || !in_array($map, $changedFields, true)) {
                    continue;
                }
            }
            
            $auditDetail = new $auditDetailClass();
            assert($auditDetail instanceof AuditDetailInterface);
            
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
        
        self::$parentId = (!empty($model->hasDirtyRelated())) ? $audit->getId() : null;
        return $save;
    }
    
    /**
     * Return true if data has been collected
     */
    protected function collectData(ModelInterface $model): bool
    {
        if ($model->hasSnapshotData()) {
            $this->snapshot = $model->getSnapshotData();
            $this->changedFields = $model->getChangedFields();
            return true;
        }
    
        $this->snapshot = null;
        $this->changedFields = null;
        return false;
    }
}
