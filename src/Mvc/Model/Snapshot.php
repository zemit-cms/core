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

use Phalcon\Mvc\ModelInterface;
use Zemit\Mvc\Model\AbstractTrait\AbstractEventsManager;
use Zemit\Mvc\Model\Behavior\Snapshot as SnapshotBehavior;

trait Snapshot
{
    use AbstractEventsManager;
    
    public SnapshotBehavior $snapshotBehavior;
    
    abstract protected function keepSnapshots(bool $keepSnapshot): void;
    
    /**
     * Initializing Snapshot
     */
    public function initializeSnapshot(?array $options = null): void
    {
        $options ??= $this->getOptionsManager()->get('snapshot') ?? [];
        $this->keepSnapshots($options['keepSnapshots'] ?? true);
        $this->addBehavior(new SnapshotBehavior($options));
    }
    
    /**
     * Set Snapshot Behavior
     */
    public function setSnapshotBehavior(SnapshotBehavior $snapshotBehavior): void
    {
        $this->snapshotBehavior = $snapshotBehavior;
        $this->addBehavior($this->snapshotBehavior);
    }
    
    /**
     * Get Snapshot Behavior
     */
    public function getSnapshotBehavior(): SnapshotBehavior
    {
        return $this->snapshotBehavior;
    }
    
    /**
     * Check if the model has changed and return null otherwise
     */
    public function hasChangedCallback(callable $callback, bool $anyField = true): \Closure
    {
        return function (ModelInterface $model, $field) use ($callback, $anyField) {
            return (!$model->hasSnapshotData()
                || $model->hasChanged($anyField ? null : $field)
                || $model->hasUpdated($anyField ? null : $field))
                ? $callback($model, $field)
                : $model->readAttribute($field);
        };
    }
}
