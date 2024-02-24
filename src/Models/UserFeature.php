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

use Zemit\Models\Abstracts\AbstractUserFeature;
use Zemit\Models\Interfaces\UserFeatureInterface;

/**
 * @property User $UserEntity
 * @method User getUserEntity(?array $params = null)
 * 
 * @property Feature $FeatureEntity
 * @method Feature getFeatureEntity(?array $params = null)
 */
class UserFeature extends AbstractUserFeature implements UserFeatureInterface
{
    protected $deleted = self::NO;
    protected $position = self::NO;

    public function initialize(): void
    {
        parent::initialize();

        $this->hasOne('userId', User::class, 'id', ['alias' => 'User']);
        $this->hasOne('featureId', Feature::class, 'id', ['alias' => 'Feature']);
    }

    public function validation(): bool
    {
        $validator = $this->genericValidation();
        
        $this->addUniquenessValidation($validator, ['userId', 'featureId']);
        $this->addUnsignedIntValidation($validator, 'userId', false);
        $this->addUnsignedIntValidation($validator, 'featureId', false);

        return $this->validate($validator);
    }
}
