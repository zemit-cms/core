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
        
        $this->hasMany('id', File::Class, 'userId', ['alias' => 'Files']);
        
        $this->hasMany('id', UserGroup::class, 'userId', ['alias' => 'GroupNodes']);
        $this->hasManyToMany(
            'id',
            UserGroup::Class,
            'userId',
            'groupId',
            Group::class,
            'id',
            ['alias' => 'Groups']
        );
        
        $this->hasMany('id', UserRole::class, 'userId', ['alias' => 'RoleNodes']);
        $this->hasManyToMany(
            'id',
            UserRole::Class,
            'userId',
            'roleId',
            Role::class,
            'id',
            ['alias' => 'Roles']
        );
        
        $this->hasMany('id', UserType::class, 'userId', ['alias' => 'TypeNodes']);
        $this->hasManyToMany(
            'id',
            UserType::Class,
            'userId',
            'typeId',
            Type::class,
            'id',
            ['alias' => 'Types']
        );
        
        $this->hasMany('id', UserFeature::class, 'userId', ['alias' => 'FeatureNodes']);
        $this->hasManyToMany(
            'id',
            UserFeature::Class,
            'userId',
            'featureId',
            Feature::class,
            'id',
            ['alias' => 'Features']
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
