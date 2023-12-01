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

use Zemit\Models\Abstracts\AbstractSetting;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength\Max;
use Phalcon\Validation\Validator\Uniqueness;
use Zemit\Models\Interfaces\SettingInterface;

class Setting extends AbstractSetting implements SettingInterface
{
    protected $deleted = self::NO;

    public function initialize(): void
    {
        parent::initialize();
    }

    public function validation(): bool
    {
        $validator = $this->genericValidation();

        $validator->add('index', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('index', new Max(['max' => 255, 'message' => $this->_('length-exceeded')]));
        $validator->add('index', new Uniqueness(['message' => $this->_('not-unique')]));

        $validator->add('category', new Max(['max' => 255, 'message' => $this->_('length-exceeded')]));

        $validator->add('label', new Max(['max' => 255, 'message' => $this->_('length-exceeded')]));

        return $this->validate($validator);
    }
}
