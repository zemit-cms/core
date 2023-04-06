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

use Zemit\Mvc\Model;
use Zemit\Mvc\Model\AbstractTrait\AbstractBehavior;
use Zemit\Mvc\Model\Behavior\Transformable;
use Zemit\Mvc\Model\Identity;
use Zemit\Mvc\Model\Options;
use Zemit\Mvc\Model\Snapshots;
use Zemit\Mvc\Model\SoftDelete;

trait Deleted
{
    use AbstractBehavior;
    use Options;
    use Identity;
    use Snapshots;
    use SoftDelete;
    
    public Transformable $deletedBehavior;
    
    /**
     * Initializing Deleted
     */
    public function initializeDeleted(?array $options = null): void
    {
        $options ??= $this->getOptionsManager()->get('deleted') ?? [];
        
        $fieldBy = $options['fieldBy'] ?? 'deletedBy';
        $fieldAs = $options['fieldAs'] ?? 'deletedAs';
        $fieldAt = $options['fieldAt'] ?? 'deletedAt';
        
        $this->setDeletedBehavior(new Transformable([
            'beforeDelete' => [
                $fieldBy => $this->getCurrentUserIdCallback(false),
                $fieldAs => $this->getCurrentUserIdCallback(true),
                $fieldAt => date(Model::DATETIME_FORMAT),
            ],
            'beforeValidationOnUpdate' => [
                $fieldBy => $this->hasChangedCallback(function ($model, $field) {
                    return $model->isDeleted()
                        ? $this->getCurrentUserIdCallback()()
                        : $model->readAttribute($field);
                }),
                $fieldAs => $this->hasChangedCallback(function ($model, $field) {
                    return $model->isDeleted()
                        ? $this->getCurrentUserIdCallback(true)()
                        : $model->readAttribute($field);
                }),
                $fieldAt => $this->hasChangedCallback(function ($model, $field) {
                    return $model->isDeleted()
                        ? date(Model::DATETIME_FORMAT)
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
        $this->deletedBehavior = $deletedBehavior;
        $this->addBehavior($this->deletedBehavior);
    }
    
    /**
     * Get Deleted Behavior
     */
    public function getDeletedBehavior(): Transformable
    {
        return $this->deletedBehavior;
    }
}
