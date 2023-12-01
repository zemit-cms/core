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

use Zemit\Models\Abstracts\AbstractAuditDetail;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\StringLength\Max;
use Zemit\Models\Interfaces\AuditDetailInterface;

/**
 * @property Audit $AuditEntity
 *
 * @method Audit getAuditEntity(?array $params = null)
 */
class AuditDetail extends AbstractAuditDetail implements AuditDetailInterface
{
    const EVENT_CREATE = 'create';
    const EVENT_UPDATE = 'update';
    const EVENT_DELETE = 'delete';
    const EVENT_RESTORE = 'restore';
    const EVENT_OTHER = 'other';

    protected $event = self::EVENT_OTHER;
    protected $deleted = self::NO;

    public function initialize(): void
    {
        parent::initialize();

        $this->belongsTo('auditId', Audit::class, 'id', ['alias' => 'AuditEntity']);
    }

    public function validation(): bool
    {
        $validator = $this->genericValidation();
        $eventInclusions = [self::EVENT_CREATE, self::EVENT_UPDATE, self::EVENT_DELETE, self::EVENT_RESTORE, self::EVENT_OTHER];

        $validator->add('auditId', new PresenceOf(['message' => $this->_('required')]));

        $validator->add('model', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('model', new Max(['max' => 255, 'message' => $this->_('length-exceeded')]));

        $validator->add('table', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('table', new Max(['max' => 60, 'message' => $this->_('length-exceeded')]));

        $validator->add('primary', new PresenceOf(['message' => $this->_('required')]));

        $validator->add('column', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('column', new Max(['max' => 60, 'message' => $this->_('length-exceeded')]));

        $validator->add('map', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('map', new Max(['max' => 60, 'message' => $this->_('length-exceeded')]));

        $validator->add('event', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('event', new InclusionIn(['message' => $this->_('not-valid'), 'domain' => $eventInclusions]));

        return $this->validate($validator);
    }
}
