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

namespace Zemit\Mvc\Model\Traits;

use Phalcon\Mvc\Model;
use Zemit\Mvc\Model\Behavior\Snapshot as SnapshotBehavior;
use Zemit\Mvc\Model\Traits\Abstracts\AbstractBehavior;
use Zemit\Mvc\Model\Traits\Abstracts\AbstractEventsManager;
use Zemit\Mvc\Model\Traits\Abstracts\AbstractOptions;

/**
 * Trait that provides snapshot functionality for a model.
 */
trait Snapshot
{
    use AbstractEventsManager;
    use AbstractOptions;
    use AbstractBehavior;
    
    abstract protected function keepSnapshots(bool $keepSnapshot): void;
    
    /**
     * Initialize the snapshot for the model.
     *
     * @param array|null $options An array of options for initializing the snapshot (default: null)
     *
     * @return void
     */
    public function initializeSnapshot(?array $options = null): void
    {
        $options ??= $this->getOptionsManager()->get('snapshot') ?? [];
        
        $this->keepSnapshots($options['keepSnapshots'] ?? true);
        $this->setSnapshotBehavior(new SnapshotBehavior($options));
    }
    
    /**
     * Set the SnapshotBehavior for the model
     *
     * @param SnapshotBehavior $snapshotBehavior The SnapshotBehavior instance to set
     *
     * @return void
     */
    public function setSnapshotBehavior(SnapshotBehavior $snapshotBehavior): void
    {
        $this->setBehavior('snapshot', $snapshotBehavior);
    }
    
    /**
     * Get the SnapshotBehavior instance for the model.
     *
     * @return SnapshotBehavior The SnapshotBehavior instance.
     */
    public function getSnapshotBehavior(): SnapshotBehavior
    {
        $behavior = $this->getBehavior('snapshot');
        assert($behavior instanceof SnapshotBehavior);
        return $behavior;
    }
    
    /**
     * Creates a closure that can be used as a callback to determine if a model attribute has changed.
     *
     * @param callable $callback The callback function to be executed if the model attribute has changed.
     * @param bool $anyField Determines whether to check for changes in any field (default: true).
     *
     * @return \Closure A closure that takes a Model instance and a field name as arguments, and returns the result of the callback
     *         function if the attribute has changed, or the value of the attribute if it has not changed.
     */
    public function hasChangedCallback(callable $callback, bool $anyField = true): \Closure
    {
        return function (Model $model, string $field) use ($callback, $anyField): mixed {
            return (!$model->hasSnapshotData()
                || $model->hasChanged($anyField ? null : $field)
                || $model->hasUpdated($anyField ? null : $field))
                ? $callback($model, $field)
                : $model->readAttribute($field);
        };
    }
}
