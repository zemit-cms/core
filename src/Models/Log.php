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

use Zemit\Models\Base\AbstractLog;
use Phalcon\Logger;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Date;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength\Max;
use Phalcon\Validation\Validator\Uniqueness;

/**
 * Class Log
 *
* @package Zemit\Models
*/
class Log extends AbstractLog
{
    const LEVEL_CUSTOM = 'custom';
    const LEVEL_DEBUG = 'debug';
    const LEVEL_INFO = 'info';
    const LEVEL_CRITICAL = 'critical';
    const LEVEL_EMERGENCY = 'emergency';
    const LEVEL_WARNING = 'warning';
    const LEVEL_NOTICE = 'notice';
    const LEVEL_ALERT = 'alert';
    
    const TYPE_CUSTOM = Logger::CUSTOM;
    const TYPE_DEBUG = Logger::DEBUG;
    const TYPE_INFO = Logger::INFO;
    const TYPE_CRITICAL = Logger::CRITICAL;
    const TYPE_EMERGENCY = Logger::EMERGENCY;
    const TYPE_WARNING = Logger::WARNING;
    const TYPE_NOTICE = Logger::NOTICE;
    const TYPE_ALERT = Logger::ALERT;
    
    protected $deleted = self::NO;

    public function initialize()
    {
        parent::initialize();
    }
    
    public function validation()
    {
        $validator = $this->genericValidation();
        
        $validator->add('level', new PresenceOf(['message' => $this->_('levelRequired')]));
        //@TODO domain level validation
        $validator->add('type', new PresenceOf(['message' => $this->_('typeRequired')]));
        //@TODO domain type validation
        
        $validator->add('name', new PresenceOf(['message' => $this->_('nameRequired')]));
        $validator->add('name', new Max(['max' => 255, 'message' => $this->_('nameLengthExceeded'), 'included' => true]));
    
        $validator->add('message', new PresenceOf(['message' => $this->_('messageRequired')]));
        $validator->add('context', new PresenceOf(['message' => $this->_('contextRequired')]));
        
        $validator->add('time', new PresenceOf(['message' => $this->_('timeRequired')]));
        // @todo unix timestamp validation
        
        $validator->add('date', new PresenceOf(['message' => $this->_('dateRequired')]));
        // @todo datetime validation
        
        return $this->validate($validator);
    }
}
