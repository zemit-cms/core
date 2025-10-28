<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Zemit\Models;

use Zemit\Models\Abstracts\GroupFeatureAbstract;
use Zemit\Models\Interfaces\GroupFeatureInterface;

/**
 * Class GroupFeature
 *
 * This class represents a GroupFeature object.
 * It extends the GroupFeatureAbstract class and implements the GroupFeatureInterface.
 */
class GroupFeature extends GroupFeatureAbstract implements GroupFeatureInterface
{
    #[\Override]
    public function initialize(): void
    {
        parent::initialize();
        $this->addDefaultRelationships();
    }

    public function validation(): bool
    {
        $validator = $this->genericValidation();
        $this->addDefaultValidations($validator);
        return $this->validate($validator);
    }
}
