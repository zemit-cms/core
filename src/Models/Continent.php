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

use Zemit\Models\Base\AbstractContinent;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Date;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength\Max;
use Phalcon\Validation\Validator\Uniqueness;

/**
 * Class Continent
 *
* @package Zemit\Models
*/
class Continent extends AbstractContinent
{
    protected $deleted = self::NO;

    public function initialize()
    {
        parent::initialize();

        // Has many
        $this->hasMany('id', City::class, 'continentId', ['alias' => 'CityList']);
        $this->hasMany('id', Country::class, 'continentId', ['alias' => 'CountryList']);
        $this->hasMany('id', Subdivision::class, 'subdivisionId', ['alias' => 'SubdivisionList']);
    }
    
    public function validation()
    {
        $validator = $this->genericValidation();
        
        // Code
        $validator->add('code', new PresenceOf(['message' => $this->_('codeRequired')]));
        $validator->add('code', new Uniqueness(['message' => $this->_('codeNotUnique')]));
        $validator->add('code', new Max(['max' => 2, 'message' => $this->_('codeLengthExceeded'), 'included' => true]));

        // Name
        $validator->add('name', new PresenceOf(['message' => $this->_('nameRequired')]));
        $validator->add('name', new Uniqueness(['message' => $this->_('nameNotUnique')]));
        $validator->add('name', new Max(['max' => 70, 'message' => $this->_('nameLengthExceeded'), 'included' => true]));

        return $this->validate($validator);
    }
}
