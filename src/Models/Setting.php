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
use Phalcon\Validation;
use Phalcon\Validation\Validator\Date;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength\Max;

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

        // Index
        $validator->add('index', new PresenceOf(['message' => $this->_('indexRequired')]));
        $validator->add('index', new Max(['max' => 255, 'message' => $this->_('indexLengthExceeded'), 'included' => true]));

        // Category
        $validator->add('category', new Max(['max' => 255, 'message' => $this->_('categoryLengthExceeded'), 'included' => true]));

        // Label
        $validator->add('label', new Max(['max' => 255, 'message' => $this->_('labelLengthExceeded'), 'included' => true]));
        
        return $this->validate($validator);
    }
}
