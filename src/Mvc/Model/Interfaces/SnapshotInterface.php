<?php

declare(strict_types=1);

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit Team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace PhalconKit\Mvc\Model\Interfaces;

use PhalconKit\Mvc\Model\Behavior\Snapshot as SnapshotBehavior;

interface SnapshotInterface
{
    public function initializeSnapshot(?array $options = null): void;

    public function setSnapshotBehavior(SnapshotBehavior $snapshotBehavior): void;

    public function getSnapshotBehavior(): SnapshotBehavior;

    public function hasChangedCallback(callable $callback, bool $anyField = true): \Closure;
}
