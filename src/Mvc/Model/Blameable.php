<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model;

use Phalcon\Mvc\Model\Relation;
use Zemit\Config\ConfigInterface;
use Zemit\Models\Audit;
use Zemit\Models\AuditDetail;
use Zemit\Models\User;
use Zemit\Mvc\Model\AbstractTrait\AbstractBehavior;
use Zemit\Mvc\Model\AbstractTrait\AbstractIdentity;
use Zemit\Mvc\Model\AbstractTrait\AbstractInjectable;
use Zemit\Mvc\Model\Behavior\Blameable as BlameableBehavior;

trait Blameable
{
    use AbstractBehavior;
    use AbstractIdentity;
    use AbstractInjectable;
    
    use Options;
    
    use Blameable\Created;
    use Blameable\Updated;
    use Blameable\Deleted;
    use Blameable\Restored;
    
    /**
     * Initializing Blameable
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
     * Set Blameable Behavior
     */
    public function setBlameableBehavior(BlameableBehavior $blameableBehavior): void
    {
        $this->setBehavior('blameable', $blameableBehavior);
    }
    
    /**
     * Get Blameable Behavior
     */
    public function getBlameableBehavior(): BlameableBehavior
    {
        $blameableBehavior = $this->getBehavior('blameable');
        assert($blameableBehavior instanceof BlameableBehavior);
        return $blameableBehavior;
    }
    
    /**
     * Add a user relationship
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
            $class ??= $this->getIdentity()->getUserClass() ?: $this->getDI()->get('config')->getModelClass(\Zemit\Models\User::class);
            return $this->$type($field, $class, $ref, ['alias' => $alias, 'params ' => $params]);
        }
        
        return null;
    }
}
