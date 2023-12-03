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

use Zemit\Models\Abstracts\AbstractTemplate;
use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Filter\Validation\Validator\StringLength\Max;
use Zemit\Models\Interfaces\TemplateInterface;

class Template extends AbstractTemplate implements TemplateInterface
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
