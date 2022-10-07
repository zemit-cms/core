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

use Phalcon\Di\Di;
use Phalcon\Session\Manager;
use Zemit\Models\Base\AbstractSession;
use Phalcon\Mvc\Model\Behavior\Timestampable;
use Phalcon\Encryption\Security;
use Phalcon\Filter\Validation\Validator\Date;
use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Filter\Validation\Validator\Uniqueness;
use Phalcon\Filter\Validation\Validator\StringLength\Max;

/**
 * Class Session
 *
 * @property User $User
 * @property User $UserAs
 *
 * @method User getUser($params = null)
 * @method User getUserAs($params = null)
 *
 * @package Zemit\Models
 */
class Session extends AbstractSession
{
    protected $deleted = self::NO;

    public function initialize()
    {
        parent::initialize();

        /** @var Security $security */
        $security = $this->getDI()->get('security');

        $this->belongsTo('asUserId', User::class, 'id', ['alias' => 'UserAsEntity']);

        // refresh date
        $this->addBehavior(new Timestampable([
            'beforeValidation' => [
                'field' => 'date',
                'format' => 'Y-m-d H:i:s',
            ],
        ]));
    }

    public function validation()
    {
        $validator = $this->genericValidation();

        $validator->add('key', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('key', new Uniqueness(['message' => $this->_('not-unique')]));
        $validator->add('key', new Max(['max' => 60, 'message' => $this->_('length-exceeded')]));

        $validator->add('token', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('token', new Max(['max' => 128, 'message' => $this->_('length-exceeded')]));

        $validator->add('date', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('date', new Date(['format' => 'Y-m-d H:i:s', 'message' => $this->_('date-not-valid')]));

        return $this->validate($validator);
    }
    
    public function save(): bool {
        return self::_isSessionAdapter()? $this->_saveIntoSession() : parent::save();
    }
    
    public function update(): bool {
        return self::_isSessionAdapter()? $this->_saveIntoSession() : parent::update();
    }
    
    public function create(): bool {
        return self::_isSessionAdapter()? $this->_saveIntoSession() : parent::create();
    }
    
    public function delete(): bool {
        return self::_isSessionAdapter()? $this->_removeFromSession() : parent::delete();
    }
    
    static public function findFirstByKey($key) {
        $session = Di::getDefault()->get('session');
        if (self::_isSessionAdapter()) {
            if ($session->has('zemit-session-' . $key)) {
                $sessionStore = $session->get('zemit-session-' . $key);
                $model = new self();
                $model->setKey($sessionStore['key']);
                $model->setToken($sessionStore['token']);
                $model->setDate($sessionStore['date'] ?? date('Y-m-d H:i:s'));
                $model->setUserId($sessionStore['userId'] ?? null);
                $model->setAsUserId($sessionStore['asUserId'] ?? null);
                return $model;
            }
            return false;
        }
        return parent::findFirstByKey($key);
    }
    
    /**
     * Check if we should save into the database or the session
     * @return bool
     */
    static public function _isSessionAdapter() {
        return true;
    }
    
    /**
     * Save the key into the session
     * @return bool
     */
    public function _saveIntoSession() {
        /** @var Manager $session */
        $session = $this->getDI()->get('session');
        $session->set('zemit-session-' . $this->getKey(), $this->toArray());
        return true;
    }
    
    /**
     * Save the key into the session
     * @return bool
     */
    public function _removeFromSession() {
        /** @var Manager $session */
        $session = $this->getDI()->get('session');
        $session->remove('zemit-session-' . $this->getKey());
        return true;
    }
}
