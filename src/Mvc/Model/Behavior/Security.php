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
use Phalcon\Text;
use Zemit\Config\Config;
use Zemit\Config\ConfigInterface;
use Zemit\Identity;

/**
 * Allows to check if the current identity is allowed to run some model actions
 * this behavior will stop operations if not allowed
 */
class Security extends Behavior
{
    
    protected Config $config;
    
    protected \Zemit\Security $security;
    
    protected Identity $identity;
    
    
    public function __construct(?array $options = null)
    {
        parent::__construct($options);
        $this->config ??= Di::getDefault()->get('config');
        $this->security ??= Di::getDefault()->get('security');
        $this->identity ??= Di::getDefault()->get('identity');
    }
    
    /**
     * Handling security on some model events
     * - beforeCreate
     * - beforeUpdate
     * - beforeDelete
     * - beforeRestore
     *
     * {@inheritdoc}
     */
    public function notify(string $type, ModelInterface $model): bool
    {
        $this->security->getAcl();
        switch ($type) {
            case 'beforeFind': // @todo implement this
            case 'beforeFindFirst': // @todo implement this
            case 'beforeCount':  // @todo implement this
            case 'beforeSum': // @todo implement this
            case 'beforeAverage': // @todo implement this
            case 'beforeCreate':
            case 'beforeUpdate':
            case 'beforeDelete':
            case 'beforeRestore':
            case 'beforeReorder':
                $type = lcfirst(Text::camelize(str_replace(['before_', 'after_'], [null, null], Text::uncamelize($type))));
                return $this->isAllowed($type, $model);
        }
        
        return true;
    }
    
    public function isAllowed(string $type, ModelInterface $model): bool
    {
        $acl = $this->security->getAcl(['models', 'components']);
        $modelClass = get_class($model);
        
        // component not found
        if (!$acl->isComponent($modelClass)) {
            $model->appendMessage(new Message(
                'Model permission not found for `' . $modelClass . '`',
                'id',
                'NotFound',
                404
            ));
            return false;
        }
        
        // allowed for roles
        $roles = $this->identity->getAclRoles();
        foreach ($roles as $role) {
            if ($acl->isAllowed($role, $modelClass, $type)) {
                return true;
            }
        }
        
        $model->appendMessage(new Message(
            'Current identity forbidden to execute `' . $type . '` on `' . $modelClass . '`',
            'id',
            'NotFound',
            403
        ));
        return false;
    }
}
