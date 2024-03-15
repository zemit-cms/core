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

use Zemit\Models\Abstracts\RoleFeatureAbstract;
use Zemit\Models\Interfaces\RoleFeatureInterface;

/**
 * Class RoleFeature
 *
 * This class represents a RoleFeature object.
 * It extends the RoleFeatureAbstract class and implements the RoleFeatureInterface.
 */
class RoleFeature extends RoleFeatureAbstract implements RoleFeatureInterface
{
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
