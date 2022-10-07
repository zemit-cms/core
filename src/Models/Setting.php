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

use Zemit\Models\Base\AbstractSetting;
use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Filter\Validation\Validator\StringLength\Max;
use Phalcon\Filter\Validation\Validator\Uniqueness;


/**
 * Class Setting
 *
 * @package Zemit\Models
 */
class Setting extends AbstractSetting
{
    protected $deleted = self::NO;

    public function initialize()
    {
        parent::initialize();
    }

    public function validation()
    {
        $validator = $this->genericValidation();

        $validator->add('index', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('index', new Max(['max' => 255, 'message' => $this->_('length-exceeded')]));
        $validator->add('index', new Uniqueness(['message' => $this->_('not-unique')]));

        $validator->add('category', new Max(['max' => 255, 'message' => $this->_('length-exceeded')]));

        $validator->add('labelFr', new Max(['max' => 255, 'message' => $this->_('length-exceeded')]));
        $validator->add('labelEn', new Max(['max' => 255, 'message' => $this->_('length-exceeded')]));

        return $this->validate($validator);
    }
}
