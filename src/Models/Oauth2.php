<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Zemit\Models;

use Zemit\Models\Abstracts\Oauth2Abstract;
use Zemit\Models\Interfaces\Oauth2Interface;

/**
 * Class Oauth2
 *
 * This class represents a Oauth2 object.
 * It extends the Oauth2Abstract class and implements the Oauth2Interface.
 */
class Oauth2 extends Oauth2Abstract implements Oauth2Interface
{
    public function initialize(): void
    {
        parent::initialize();
        $this->addDefaultRelationships();
    }

    public function validation(): bool
    {
        $validator = $this->genericValidation();
        $this->addDefaultValidations($validator);
        return $this->validate($validator);
    }
}