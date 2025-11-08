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

use PhalconKit\Models\Abstracts\RoleFeatureAbstract;
use PhalconKit\Models\Interfaces\RoleFeatureInterface;

/**
 * Class RoleFeature
 *
 * This class represents a RoleFeature object.
 * It extends the RoleFeatureAbstract class and implements the RoleFeatureInterface.
 */
class RoleFeature extends RoleFeatureAbstract implements RoleFeatureInterface
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
