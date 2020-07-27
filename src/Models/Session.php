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

use Zemit\Models\Base\AbstractSession;
use Phalcon\Mvc\Model\Behavior\Timestampable;
use Phalcon\Security;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Date;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Uniqueness;
use Phalcon\Validation\Validator\StringLength\Max;
use Zemit\Mvc\Model\Behavior\Conditional;

/**
 * Class Role
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
        
        // index
        $validator->add('key', new PresenceOf(['message' => $this->_('keyRequired')]));
        $validator->add('key', new Uniqueness(['message' => $this->_('keyUnique')]));
        $validator->add('token', new PresenceOf(['message' => $this->_('tokenRequired')]));
        
        // date
        $validator->add('date', new PresenceOf(['message' => $this->_('dateRequired')]));
        $validator->add('date', new Date(['format' => 'Y-m-d H:i:s', 'message' => $this->_('dateNotValid')]));
    
        return $this->validate($validator);
    }
}
