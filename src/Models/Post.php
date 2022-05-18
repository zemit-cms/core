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

use Zemit\Models\Base\AbstractPost;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength\Max;

/**
 * Class Post
 *
 * @package Zemit\Models
 */
class Post extends AbstractPost
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