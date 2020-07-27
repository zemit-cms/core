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

use Zemit\Models\Base\AbstractAudit;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\InclusionIn;

/**
 * Class Audit
 *
* @package Zemit\Models
*/
class Audit extends AbstractAudit
{
    const EVENT_CREATE = 'create';
    const EVENT_UPDATE = 'update';
    const EVENT_DELETE = 'delete';
    const EVENT_RESTORE = 'restore';
    const EVENT_OTHER = 'other';
    
    protected $event = self::EVENT_OTHER;
    protected $deleted = self::NO;

    public function initialize()
    {
        parent::initialize();

        $this->hasMany('id', AuditDetail::class, 'auditId', ['alias' => 'AuditDetailList']);
    }
    
    public function validation()
    {
        $validator = $this->genericValidation();
        
        $eventInclusions = [self::EVENT_CREATE, self::EVENT_UPDATE, self::EVENT_DELETE, self::EVENT_RESTORE, self::EVENT_OTHER];
        
        $validator->add('model', new PresenceOf(['message' => $this->_('modelIsRequired')]));
        $validator->add('table', new PresenceOf(['message' => $this->_('tableIsRequired')]));
        $validator->add('primary', new PresenceOf(['message' => $this->_('primaryIsRequired')]));
        $validator->add('event', new PresenceOf(['message' => $this->_('eventIsRequired')]));
    
        $validator->add('event', new InclusionIn(['message' => $this->_('eventNotValid'), 'domain' => $eventInclusions]));
        
        return $this->validate($validator);
    }
}
