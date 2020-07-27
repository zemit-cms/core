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
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength\Max;

/**
 * Class Template
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
    
        // index
        $validator->add('index', new Max(['max' => 50, 'message' => $this->_('indexLengthExceeded'), 'included' => true]));
        $validator->add('index', new PresenceOf(['message' => $this->_('indexRequired')]));
    
        // Label
        $validator->add('label', new PresenceOf(['message' => $this->_('labelRequired')]));
        $validator->add('label', new Max(['max' => 100, 'message' => $this->_('labelLengthExceeded'), 'included' => true]));
    
        // Subject Fr
        $validator->add('subjectFr', new PresenceOf(['message' => $this->_('subjectFrRequired')]));
        $validator->add('subjectFr', new Max(['max' => 100, 'message' => $this->_('subjectFrLengthExceeded'), 'included' => true]));
    
        // Subject En
        $validator->add('subjectEn', new PresenceOf(['message' => $this->_('subjectEnRequired')]));
        $validator->add('subjectEn', new Max(['max' => 100, 'message' => $this->_('subjectEnLengthExceeded'), 'included' => true]));
    
        return $this->validate($validator);
    }
}
