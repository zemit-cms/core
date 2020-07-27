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

use Zemit\Models\Base\AbstractTranslation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength\Max;
use Phalcon\Validation\Validator\Uniqueness;

/**
 * Class Setting
 *
* @package Zemit\Models
*/
class Translation extends AbstractTranslation
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
        $validator->add('index', new Uniqueness(['message' => $this->_('indexUniqueness')]));
        $validator->add('index', new PresenceOf(['message' => $this->_('indexRequired')]));
        $validator->add('index', new Max(['max' => 60, 'message' => $this->_('indexLengthExceeded'), 'included' => true]));
        
        // Label
        $validator->add('label', new PresenceOf(['message' => $this->_('labelFrRequired')]));
        $validator->add('valueEn', new Max(['max' => 255, 'message' => $this->_('valueEnLengthExceeded'), 'included' => true]));
        
        return $this->validate($validator);
    }
}
