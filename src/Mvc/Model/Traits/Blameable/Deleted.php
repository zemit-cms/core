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

namespace Zemit\Mvc\Model\Traits\Blameable;

use Zemit\Db\Column;
use Zemit\Mvc\Model\Behavior\Transformable;
use Zemit\Mvc\Model\Interfaces\SoftDeleteInterface;
use Zemit\Mvc\Model\Traits\Abstracts\AbstractBehavior;
use Zemit\Mvc\Model\Traits\Abstracts\AbstractBlameable;
use Zemit\Mvc\Model\Traits\Identity;
use Zemit\Mvc\Model\Traits\Options;
use Zemit\Mvc\Model\Traits\Snapshot;
use Zemit\Mvc\Model\Traits\SoftDelete;
use Zemit\Mvc\ModelInterface;

trait Deleted
{
    use AbstractBehavior;
    use AbstractBlameable;
    use Options;
    use Identity;
    use Snapshot;
    use SoftDelete;
    use BlameAt;
    
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
                $fieldAt => $this->getDateCallback(Column::DATETIME_FORMAT),
            ],
            'beforeValidationOnUpdate' => [
                $fieldBy => $this->hasChangedCallback(function (ModelInterface $model, string $field) use ($deletedField, $deletedValue): ?int {
                    return $model->isDeleted($deletedField, $deletedValue)
                        ? $this->getCurrentUserIdCallback()()
                        : $model->readAttribute($field);
                }),
                $fieldAs => $this->hasChangedCallback(function (ModelInterface $model, string $field) use ($deletedField, $deletedValue): ?int {
                    return $model->isDeleted($deletedField, $deletedValue)
                        ? $this->getCurrentUserIdCallback(true)()
                        : $model->readAttribute($field);
                }),
                $fieldAt => $this->hasChangedCallback(function (ModelInterface $model, string $field) use ($deletedField, $deletedValue): ?string {
                    return $model->isDeleted($deletedField, $deletedValue)
                        ? $this->getDateCallback(Column::DATETIME_FORMAT)()
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
