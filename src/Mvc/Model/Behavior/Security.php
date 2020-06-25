<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model\Behavior;

use Phalcon\Di;
use Phalcon\Messages\Message;
use Phalcon\Mvc\Model\Behavior\Exception;
use Phalcon\Mvc\ModelInterface;
use Phalcon\Mvc\Model\Behavior;
use Zemit\Models\Group;
use Zemit\Models\Role;
use Zemit\Models\Session;
use Zemit\Models\Type;
use Zemit\Mvc\Model\User;

/**
 * Zemit\Mvc\Model\Behavior\Security
 *
 * Allows to check if the current identity is allowed to run some model actions
 * this behavior will stop operations if not allowed
 */
class Security extends Behavior
{
    /**
     * @var string
     */
    protected $sessionClass = Session::class;
    
    /**
     * @var string
     */
    protected $userClass = User::class;
    
    /**
     * @var string
     */
    protected $roleClass = Role::class;
    
    /**
     * @var string
     */
    protected $groupClass = Group::class;
    
    /**
     * @var string
     */
    protected $typeClass = Type::class;
    
    /**
     * @var \Zemit\Security
     */
    protected $security = null;
    
    /**
     * @var \Zemit\Identity
     */
    protected $identity = null;
    
    /**
     * Security constructor.
     *
     * @param array|null $options
     *
     * @throws Exception
     */
    public function __construct($options = null)
    {
        parent::__construct($options);
        
        $this->sessionClass = $options['sessionClass'] ?? $this->sessionClass;
        $this->userClass = $options['userClass'] ?? $this->userClass;
        $this->groupClass = $options['groupClass'] ?? $this->groupClass;
        $this->typeClass = $options['typeClass'] ?? $this->typeClass;
        $this->roleClass = $options['roleClass'] ?? $this->roleClass;
        $this->security ??= Di::getDefault()->get('security');;
        $this->identity ??= Di::getDefault()->get('identity');;
    }
    
    /**
     * Handling security on some model events
     * - beforeCreate
     * - beforeUpdate
     * - beforeDelete
     * - beforeRestore
     *
     * {@inheritdoc}
     *
     * @param string $eventType
     * @param \Phalcon\Mvc\ModelInterface $model
     */
    public function notify($eventType, ModelInterface $model)
    {
        $this->security->getAcl();
        
        switch($eventType) {
            case 'beforeCreate':
            case 'beforeUpdate':
            case 'beforeDelete':
            case 'beforeRestore':
                return true;
                return $this->isAllowed($eventType, $model);
                break;
        }
        
        return true;
    }
    
    public function isAllowed($eventType, $model)
    {
        $acl = $this->security->getAcl('models');
        
        $modelClass = get_class($model);
        
        // whitelisted models
//        if ($modelClass instanceof $this->userClass) {
//            return true;
//        }
        
        // component not found
        if (!$acl->isComponent($modelClass)) {
            $model->appendMessage(new Message('Model permission not found for `' . $modelClass . '`', 'id', 'NotFound', 404));
            return false;
        }
        
        // allowed for everyone
        if ($acl->isAllowed('everyone', $modelClass, $eventType)) {
            return true;
        }
        
        // allowed for roles
        $roles = $this->identity->getAclRoles();
        foreach ($roles as $role) {
            if ($acl->isAllowed($role, $modelClass, $eventType)) {
                return true;
            }
        }
        
        $model->appendMessage(new Message('Current identity forbidden to execute `' . $eventType . '` on `' . $modelClass . '`', 'id', 'NotFound', 403));
        return false;
    }
}
