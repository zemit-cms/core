<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Models\Behaviors;

use Zemit\Models\Behaviors\Blameable\CreatedInterface;
use Zemit\Models\Behaviors\Blameable\DeletedInterface;
use Zemit\Models\Behaviors\Blameable\RestoredInterface;
use Zemit\Models\Behaviors\Blameable\UpdateInterface;

interface BlameableInterface extends
    CreatedInterface,
    UpdateInterface,
    DeletedInterface,
    RestoredInterface
{
}
