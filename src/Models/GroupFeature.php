<?php

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit Team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PhalconKit\Models;

use PhalconKit\Models\Abstracts\GroupFeatureAbstract;
use PhalconKit\Models\Interfaces\GroupFeatureInterface;

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
