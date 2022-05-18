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
use Phalcon\Validation\Validator\Date;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Uniqueness;
use Phalcon\Validation\Validator\StringLength\Max;

/**
 * Class Session
 *
 * @property User $UserAs
 *
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
}
