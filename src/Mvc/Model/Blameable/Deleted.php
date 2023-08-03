<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model\Blameable;

use Zemit\Db\Column;
use Zemit\Mvc\Model\AbstractTrait\AbstractBehavior;
use Zemit\Mvc\Model\Behavior\Transformable;
use Zemit\Mvc\Model\Identity;
use Zemit\Mvc\Model\Options;
use Zemit\Mvc\Model\Snapshot;
use Zemit\Mvc\Model\SoftDelete;

trait Deleted
{
    use AbstractBehavior;
    use Options;
    use Identity;
    use Snapshot;
    use SoftDelete;
    
    /**
     * Initializing Deleted
     */
    public function initializeDeleted(?array $options = null): void
    {
        $options ??= $this->getOptionsManager()->get('deleted') ?? [];
        
        $deletedField = $options['field'] ?? 'deleted';
        $deletedValue = $options['value'] ?? 1;
        
        $fieldBy = $options['fieldBy'] ?? 'deletedBy';
        $fieldAs = $options['fieldAs'] ?? 'deletedAs';
        $fieldAt = $options['fieldAt'] ?? 'deletedAt';
        
        $this->addUserRelationship($fieldBy, 'DeletedBy');
        $this->addUserRelationship($fieldAs, 'DeletedAs');
        
        $this->setDeletedBehavior(new Transformable([
            'beforeDelete' => [
                $fieldBy => $this->getCurrentUserIdCallback(),
                $fieldAs => $this->getCurrentUserIdCallback(true),
                $fieldAt => date(Column::DATETIME_FORMAT),
            ],
            'beforeValidationOnUpdate' => [
                $fieldBy => $this->hasChangedCallback(function ($model, $field) use ($deletedField, $deletedValue) {
                    return $model->isDeleted($deletedField, $deletedValue)
                        ? $this->getCurrentUserIdCallback()()
                        : $model->readAttribute($field);
                }),
                $fieldAs => $this->hasChangedCallback(function ($model, $field) use ($deletedField, $deletedValue) {
                    return $model->isDeleted($deletedField, $deletedValue)
                        ? $this->getCurrentUserIdCallback(true)()
                        : $model->readAttribute($field);
                }),
                $fieldAt => $this->hasChangedCallback(function ($model, $field) use ($deletedField, $deletedValue) {
                    return $model->isDeleted($deletedField, $deletedValue)
                        ? date(Column::DATETIME_FORMAT)
                        : $model->readAttribute($field);
                }),
            ],
        ]));
    }
    
    /**
     * Set Deleted Behavior
     */
    public function setDeletedBehavior(Transformable $deletedBehavior): void
    {
        $this->setBehavior('deleted', $deletedBehavior);
    }
    
    /**
     * Get Deleted Behavior
     */
    public function getDeletedBehavior(): Transformable
    {
        $behavior = $this->getBehavior('deleted');
        assert($behavior instanceof Transformable);
        return $behavior;
    }
}
