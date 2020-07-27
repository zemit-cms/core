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

use Zemit\Models\Base\AbstractTimezone;
use Phalcon\Validation\Validator\Date;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength\Max;
use Phalcon\Validation\Validator\Uniqueness;

/**
 * Class Timemzone
 *
* @package Zemit\Models
*/
class Timezone extends AbstractTimezone
{
    protected $deleted = self::NO;

    public function initialize()
    {
        parent::initialize();
        $this->hasMany('id', City::class, 'timezoneId', ['alias' => 'CityList']);
    }
    
    public function validation()
    {
        $validator = $this->genericValidation();

        // Name
        $validator->add('name', new PresenceOf(['message' => $this->_('nameRequired')]));
        $validator->add('name', new Uniqueness(['message' => $this->_('nameNotUnique')]));
        $validator->add('name', new Max(['max' => 70, 'message' => $this->_('nameLengthExceeded'), 'included' => true]));

        return $this->validate($validator);
    }
}
