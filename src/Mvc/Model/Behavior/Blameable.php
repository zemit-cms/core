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

use Phalcon\Mvc\Model\Behavior;
use Phalcon\Mvc\ModelInterface;
use Zemit\Models\User;
use Zemit\Models\Audit;
use Zemit\Models\AuditDetail;
use Zemit\Models\Interfaces\AuditDetailInterface;
use Zemit\Models\Interfaces\AuditInterface;
use Zemit\Mvc\Model;
use Zemit\Mvc\Model\Behavior\Traits\SkippableTrait;
use Zemit\Support\Helper;

/**
 * Zemit\Mvc\Model\Traits\Behavior\Blameable
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
    
    /**
     * @throws \Exception
     */
    #[\Override]
    public function notify(string $type, ModelInterface $model): ?bool
    {
        if (!$this->isEnabled()) {
            return null;
        }
        
        // prevent auditing audit & audit_detail tables
        if ($model instanceof $this->auditClass || $model instanceof $this->auditDetailClass) {
            return null;
        }
        
        assert($model instanceof Model);
        return match ($type) {
            'afterCreate', 'afterUpdate' => $this->createAudit($type, $model),
            'beforeUpdate' => $this->collectData($model),
            default => null,
        };
    }
    
    /**
     * Create new audit
     * Return true if the audit was created
     * @throws \Exception
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
        
        $audit->setModel(get_class($model));
        $audit->setTable($model->getSource());
        $audit->setPrimary($model->readAttribute('id'));
        $audit->setEvent($event);
        $audit->setBefore($snapshot ? json_encode($snapshot) : null);
        $audit->setAfter(json_encode($model->toArray()));
        $audit->setParentId(self::$parentId);
        
        // legacy fields support, these fields were removed from the audit_detail table for performance reasons
        $audit->assign([
            'columns' => $columnMap? json_encode($columnMap) : null
        ]);
        
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
            
            $auditDetail->setColumn($column);
            $auditDetail->setBefore($before);
            $auditDetail->setAfter($after);
            
            // legacy fields support, these fields were removed from the audit_detail table for performance reasons
            $auditDetail->assign([
                'model' => $audit->getModel(),
                'table' => $audit->getTable(),
                'primary' => $audit->getPrimary(),
                'event' => $event,
                'map' => $map,
            ]);
            
            $auditDetailList[] = $auditDetail;
        }
        
        $audit->assign(['AuditDetailList' => $auditDetailList]);
        $save = $audit->save();
        foreach ($audit->getMessages() as $message) {
            $message->setField('Audit.' . $message->getField());
            $model->appendMessage($message);
        }
        
        self::$parentId = (!empty($model->getDirtyRelated())) ? $audit->getId() : null;
        return $save;
    }
    
    /**
     * Return true if data has been collected
     */
    protected function collectData(Model $model): bool
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
