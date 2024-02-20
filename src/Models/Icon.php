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

use Zemit\Models\Abstracts\AbstractIcon;
use Zemit\Models\Interfaces\IconInterface;

class Icon extends AbstractIcon implements IconInterface
{
    protected $deleted = self::NO;

    public function initialize(): void
    {
        parent::initialize();
    }

    public function validation(): bool
    {
        $validator = $this->genericValidation();
        
        $this->addUuidValidation($validator, 'uuid', false);
        $this->addStringLengthValidation($validator, 'name', 3, 64, false);
        $this->addJsonValidation($validator, 'meta', true);

        return $this->validate($validator);
    }
}
