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

use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength\Max;
use Zemit\Models\Abstracts\AbstractAudit;
use Zemit\Models\Interfaces\AuditInterface;

/**
 * @property AuditDetail[] $AuditDetailList
 * @property User $CreatedByEntity
 * @property User $UpdatedByEntity
 *
 * @method AuditDetail[] getAuditDetailList(?array $params = null)
 * @method User getCreatedByEntity(?array $params = null)
 * @method User getUpdatedByEntity(?array $params = null)
 */
class Audit extends AbstractAudit implements AuditInterface
{
    public const EVENT_CREATE = 'create';
    public const EVENT_UPDATE = 'update';
    public const EVENT_DELETE = 'delete';
    public const EVENT_RESTORE = 'restore';
    public const EVENT_OTHER = 'other';

    protected $event = self::EVENT_OTHER;
    protected $deleted = self::NO;

    public function initialize(): void
    {
        parent::initialize();

        $this->hasMany('id', AuditDetail::class, 'auditId', ['alias' => 'AuditDetailList']);
        $this->belongsTo('createdBy', User::class, 'id', ['alias' => 'CreatedByEntity']);
        $this->belongsTo('updatedBy', User::class, 'id', ['alias' => 'UpdatedByEntity']);
    }

    public function validation(): bool
    {
        $validator = $this->genericValidation();
        $eventInclusions = [self::EVENT_CREATE, self::EVENT_UPDATE, self::EVENT_DELETE, self::EVENT_RESTORE, self::EVENT_OTHER];

        $validator->add('model', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('model', new Max(['max' => 255, 'message' => $this->_('length-exceeded')]));

        $validator->add('table', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('table', new Max(['max' => 60, 'message' => $this->_('length-exceeded')]));

        $validator->add('primary', new PresenceOf(['message' => $this->_('required')]));

        $validator->add('event', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('event', new InclusionIn(['message' => $this->_('not-valid'), 'domain' => $eventInclusions]));

        return $this->validate($validator);
    }
}
