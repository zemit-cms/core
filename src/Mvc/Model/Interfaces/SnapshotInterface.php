<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model\Interfaces;

use Zemit\Mvc\Model\Behavior\Snapshot as SnapshotBehavior;

interface SnapshotInterface
{
    public function initializeSnapshot(?array $options = null): void;

    public function setSnapshotBehavior(SnapshotBehavior $snapshotBehavior): void;

    public function getSnapshotBehavior(): SnapshotBehavior;

    public function hasChangedCallback(callable $callback, bool $anyField = true): \Closure;
}
