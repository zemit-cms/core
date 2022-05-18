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

use Zemit\Models\Base\AbstractChannel;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength\Max;

/**
 * Class Channel
 *
 * @package Zemit\Models
 */
class Channel extends AbstractChannel
{
    protected $deleted = self::NO;

    public function initialize()
    {
        parent::initialize();
        // @todo relationships
    }

    public function validation()
    {
        $validator = $this->genericValidation();

        // @todo validations

        return $this->validate($validator);
    }
}
