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

use Zemit\Models\Abstracts\AbstractDatatableState;

/**
 * @property User $UserEntity
 * @method User getUserEntity(?array $params = null)
 */
class DatatableState extends AbstractDatatableState
{
    protected $deleted = self::NO;

    public function initialize(): void
    {
        parent::initialize();

        $this->belongsTo('userId', User::class, 'id', ['alias' => 'UserEntity']);
    }

    public function validation(): bool
    {
        $validator = $this->genericValidation();

        // Relations
        $this->addUnsignedIntValidation($validator, 'userId');
        $this->addStringLengthValidation($validator, 'label', 1, 255, false);

        return $this->validate($validator);
    }
}
