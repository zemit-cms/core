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

use Zemit\Models\Base\AbstractTemplate;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength\Max;

/**
 * Class Template
 *
 * @property $subject
 * @property $content
 *
 * @method getSubject
 * @method getContent
 *
 * @package Zemit\Models
 */
class Template extends AbstractTemplate
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
        $validator->add('index', new Max(['max' => 50, 'message' => $this->_('length-exceeded')]));

        $validator->add('label', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('label', new Max(['max' => 100, 'message' => $this->_('length-exceeded')]));

        $validator->add('subjectFr', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('subjectFr', new Max(['max' => 100, 'message' => $this->_('length-exceeded')]));

        $validator->add('subjectEn', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('subjectEn', new Max(['max' => 100, 'message' => $this->_('length-exceeded')]));

        return $this->validate($validator);
    }
}
