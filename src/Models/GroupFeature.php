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

use Zemit\Models\Abstracts\AbstractGroupFeature;
use Zemit\Models\Interfaces\GroupFeatureInterface;

/**
 * @property Group $Group
 * @method Group getGroup(?array $params = null)
 * 
 * @property Feature $Feature
 * @method Feature getFeature(?array $params = null)
 */
class GroupFeature extends AbstractGroupFeature implements GroupFeatureInterface
{
    protected $deleted = self::NO;
    protected $position = self::NO;

    public function initialize(): void
    {
        parent::initialize();

        $this->hasOne('groupId', Group::class, 'id', ['alias' => 'Group']);
        $this->hasOne('featureId', Feature::class, 'id', ['alias' => 'Feature']);
    }

    public function validation(): bool
    {
        $validator = $this->genericValidation();

        $this->addUnsignedIntValidation($validator, 'groupId', false);
        $this->addUnsignedIntValidation($validator, 'featureId', false);
        $this->addUniquenessValidation($validator, ['groupId', 'featureId'], false);
        
        return $this->validate($validator);
    }
}
