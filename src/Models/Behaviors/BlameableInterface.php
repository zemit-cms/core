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

namespace PhalconKit\Models\Behaviors;

use PhalconKit\Models\Behaviors\Blameable\CreatedInterface;
use PhalconKit\Models\Behaviors\Blameable\DeletedInterface;
use PhalconKit\Models\Behaviors\Blameable\RestoredInterface;
use PhalconKit\Models\Behaviors\Blameable\UpdateInterface;

interface BlameableInterface extends
    CreatedInterface,
    UpdateInterface,
    DeletedInterface,
    RestoredInterface
{
}
