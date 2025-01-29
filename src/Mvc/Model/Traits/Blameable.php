<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model\Traits;

use Phalcon\Mvc\Model\Relation;
use Zemit\Config\ConfigInterface;
use Zemit\Models\Audit;
use Zemit\Models\AuditDetail;
use Zemit\Models\User;
use Zemit\Mvc\Model\Behavior\Blameable as BlameableBehavior;
use Zemit\Mvc\Model\Traits\Abstracts\AbstractBehavior;
use Zemit\Mvc\Model\Traits\Abstracts\AbstractIdentity;
use Zemit\Mvc\Model\Traits\Abstracts\AbstractInjectable;
use Zemit\Mvc\Model\Traits\Abstracts\AbstractOptions;
use Zemit\Support\Models;

trait Blameable
{
    use AbstractBehavior;
    use AbstractIdentity;
    use AbstractInjectable;
    use AbstractOptions;
    
    use Blameable\BlameAt;
    use Blameable\Created;
    use Blameable\Updated;
    use Blameable\Deleted;
    use Blameable\Restored;
    
    /**
     * Initialize Blameable
     *
     * @param array|null $options Options for the BlameableBehavior
     * @return void
     */
    public function initializeBlameable(?array $options = null): void
    {
        $options ??= $this->getOptionsManager()->get('blameable') ?? [];
        
        $config = $this->getDI()->get('config');
        assert($config instanceof ConfigInterface);
        
        $options['auditClass'] ??= $config->getModelClass(Audit::class);
        $options['auditDetailClass'] ??= $config->getModelClass(AuditDetail::class);
        $options['userClass'] ??= $config->getModelClass(User::class);
        
        $this->setBlameableBehavior(new BlameableBehavior($options));
        
        $userField = $options['userField'] ?? 'userId';
        $this->addUserRelationship($userField, 'User');
    }
    
    /**
     * Set Blameable Behavior.
     *
     * @param BlameableBehavior $blameableBehavior The `BlameableBehavior` instance to set.
     *
     * @return void
     */
    public function setBlameableBehavior(BlameableBehavior $blameableBehavior): void
    {
        $this->setBehavior('blameable', $blameableBehavior);
    }
    
    /**
     * Retrieves the BlameableBehavior instance associated with the current object.
     *
     * @return BlameableBehavior The BlameableBehavior instance.
     */
    public function getBlameableBehavior(): BlameableBehavior
    {
        $blameableBehavior = $this->getBehavior('blameable');
        assert($blameableBehavior instanceof BlameableBehavior);
        return $blameableBehavior;
    }
    
    /**
     * Adds a relationship between the current object and a user entity.
     *
     * @param string $field The field name to create the relationship on. Default is 'userId'.
     * @param string $alias The alias name for the user entity. Default is 'UserEntity'.
     * @param array $params Additional parameters for the relationship. Default is an empty array.
     * @param string $ref The reference field in the user entity. Default is 'id'.
     * @param string $type The type of relationship to create. Default is 'belongsTo'.
     * @param string|null $class The class name of the user entity. If null, it will be obtained from the identity or the global configuration.
     *
     * @return Relation|null The created relationship object, or null if the specified field does not exist in the current object.
     */
    public function addUserRelationship(
        string $field = 'userId',
        string $alias = 'UserEntity',
        array $params = [],
        string $ref = 'id',
        string $type = 'belongsTo',
        ?string $class = null
    ): ?Relation {
        if (property_exists($this, $field)) {
            
            if (empty($class)) {
                $models = $this->getDI()->get('models');
                assert($models instanceof Models);
                $class = $models->getUserClass();
            }
            
            return $this->$type($field, $class, $ref, ['alias' => $alias, 'params ' => $params]);
        }
        
        return null;
    }
}
