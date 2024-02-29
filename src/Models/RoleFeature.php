<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Models;

use Zemit\Models\Abstracts\AbstractRoleFeature;
use Zemit\Models\Interfaces\RoleFeatureInterface;

/**
 * @property Role $RoleEntity
 * @method Role getRoleEntity(?array $params = null)
 * 
 * @property Feature $FeatureEntity
 * @method Feature getFeatureEntity(?array $params = null)
 */
class RoleFeature extends AbstractRoleFeature implements RoleFeatureInterface
{
    protected $deleted = self::NO;
    protected $position = self::NO;

    public function initialize(): void
    {
        parent::initialize();

        $this->hasOne('roleId', Role::class, 'id', ['alias' => 'Role']);
        $this->hasOne('featureId', Feature::class, 'id', ['alias' => 'Feature']);
    }

    public function validation(): bool
    {
        $validator = $this->genericValidation();
        
        $this->addUniquenessValidation($validator, ['roleId', 'featureId']);
        $this->addUnsignedIntValidation($validator, 'roleId', false);
        $this->addUnsignedIntValidation($validator, 'featureId', false);

        return $this->validate($validator);
    }
}
