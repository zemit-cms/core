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

use Phalcon\Db\Column;
use Phalcon\Di;
use Phalcon\Mvc\Model\Behavior\Timestampable;
use Phalcon\Mvc\ModelInterface;
use Phalcon\Session\ManagerInterface;
use Phalcon\Validation\Validator\Date;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength\Max;
use Phalcon\Validation\Validator\Uniqueness;
use Zemit\Models\Abstracts\AbstractSession;
use Zemit\Models\Interfaces\SessionInterface;

/**
 * @property User $User
 * @property User $UserAs
 *
 * @method User getUser(?array $params = null)
 * @method User getUserAs(?array $params = null)
 */
class Session extends AbstractSession implements SessionInterface
{
    protected $deleted = self::NO;
    
    private static bool $useSessionManager = true;
    
    public static function useSessionManager(?bool $useSessionManager = null): void
    {
        self::$useSessionManager = $useSessionManager;
    }
    
    public static function isUsingSessionManager(): bool
    {
        return self::$useSessionManager;
    }
    
    public function initialize(): void
    {
        parent::initialize();
        
        $this->belongsTo('asUserId', User::class, 'id', ['alias' => 'UserAsEntity']);
        
        // refresh date
        $this->addBehavior(new Timestampable([
            'beforeValidation' => [
                'field' => 'date',
                'format' => 'Y-m-d H:i:s',
            ],
        ]));
    }
    
    public function validation(): bool
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
    
    public function save(): bool
    {
        return self::isUsingSessionManager()
            ? $this->saveToSession()
            : parent::save();
    }
    
    public function update(): bool
    {
        return self::isUsingSessionManager()
            ? $this->saveToSession()
            : parent::update();
    }
    
    public function create(): bool
    {
        return self::isUsingSessionManager()
            ? $this->saveToSession()
            : parent::create();
    }
    
    public function delete(): bool
    {
        return self::isUsingSessionManager()
            ? $this->removeFromSession()
            : parent::delete();
    }
    
    public static function findFirstByKey(?string $key = null): ?ModelInterface
    {
        if (empty($key)) {
            return null;
        }
        
        // query the session manager adapter
        if (self::isUsingSessionManager()) {
            $session = self::getSessionManager();
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
            return null;
        }
        
        // query the database
        return parent::findFirst([
            'key = :key:',
            'bind' => ['key' => $key],
            'bindTypes' => ['key' => Column::BIND_PARAM_STR],
        ]);
    }
    
    public function saveToSession(): bool
    {
        $session = $this->getSessionManager();
        $session->set('zemit-session-' . $this->getKey(), $this->toArray());
        return true;
    }
    
    public function removeFromSession(): bool
    {
        $session = $this->getSessionManager();
        $session->remove('zemit-session-' . $this->getKey());
        return true;
    }
    
    public static function getSessionManager(): ManagerInterface
    {
        return Di::getDefault()->get('session');
    }
}
