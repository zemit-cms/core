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

use Zemit\Models\Abstracts\AbstractUser;
use Zemit\Models\Interfaces\UserInterface;

/**
 * @property File[] $Files
 * @method File[] getFiles(?array $params = null)
 *
 * @property UserGroup[] $GroupNode
 * @method UserGroup[] getGroupNode(?array $params = null)
 *
 * @property Group[] $Groups
 * @method Group[] getGroups(?array $params = null)
 *
 * @property UserRole[] $RoleNode
 * @method UserRole[] getRoleNode(?array $params = null)
 *
 * @property Role[] $Roles
 * @method Role[] getRoles(?array $params = null)
 *
 * @property UserType[] $TypeNode
 * @method UserType[] getTypeNode(?array $params = null)
 *
 * @property Type[] $Types
 * @method Type[] getTypes(?array $params = null)
 *
 * @property UserFeature[] $FeatureNode
 * @method UserFeature[] getFeatureNode(?array $params = null)
 *
 * @property Feature[] $Features
 * @method Feature[] getFeatures(?array $params = null)
 */
class User extends AbstractUser implements UserInterface
{
    protected $deleted = self::NO;
    
    public function initialize(): void
    {
        parent::initialize();
        
        $this->hasMany('id', File::class, 'userId', ['alias' => 'Files']);
        
        $this->hasMany('id', UserGroup::class, 'userId', ['alias' => 'GroupNode']);
        $this->hasManyToMany(
            'id',
            UserGroup::class,
            'userId',
            'groupId',
            Group::class,
            'id',
            ['alias' => 'GroupList']
        );
        
        $this->hasMany('id', UserRole::class, 'userId', ['alias' => 'RoleNode']);
        $this->hasManyToMany(
            'id',
            UserRole::class,
            'userId',
            'roleId',
            Role::class,
            'id',
            ['alias' => 'RoleList']
        );
        
        $this->hasMany('id', UserType::class, 'userId', ['alias' => 'TypeNode']);
        $this->hasManyToMany(
            'id',
            UserType::class,
            'userId',
            'typeId',
            Type::class,
            'id',
            ['alias' => 'TypeList']
        );
        
        $this->hasMany('id', UserFeature::class, 'userId', ['alias' => 'FeatureNode']);
        $this->hasManyToMany(
            'id',
            UserFeature::class,
            'userId',
            'featureId',
            Feature::class,
            'id',
            ['alias' => 'FeatureList']
        );
    }
    
    public function validation(): bool
    {
        $validator = $this->genericValidation();
        
        $this->addEmailValidation($validator, 'email', false);
        
        return $this->validate($validator);
    }
    
    /**
     * @param string|null $password
     *
     * @return bool If the hash is valid or not
     */
    public function checkPassword(string $password = null): bool
    {
        return $password && $this->checkHash($this->getPassword(), $password);
    }
}
