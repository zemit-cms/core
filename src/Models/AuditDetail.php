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

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Zemit\Models\Base\AbstractAuditDetail;

/**
 * Class AuditDetail
 *
* @package Zemit\Models
*/
class AuditDetail extends AbstractAuditDetail
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

        $this->belongsTo('auditId', Audit::class, 'id', ['alias' => 'Audit']);
    }
    
    public function validation()
    {
        $validator = $this->genericValidation();

        $validator->add('auditId', new PresenceOf(['message' => $this->_('auditIdIsRequired')]));
        $validator->add('model', new PresenceOf(['message' => $this->_('modelIsRequired')]));
        $validator->add('table', new PresenceOf(['message' => $this->_('tableIsRequired')]));
        $validator->add('primary', new PresenceOf(['message' => $this->_('primaryIsRequired')]));
        $validator->add('column', new PresenceOf(['message' => $this->_('columnIsRequired')]));
        $validator->add('map', new PresenceOf(['message' => $this->_('mapIsRequired')]));
        
        return $this->validate($validator);
    }
}
