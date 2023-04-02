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

use Zemit\Models\Abstracts\AbstractTranslateField;
use Zemit\Models\Interfaces\TranslateFieldInterface;

class TranslateField extends AbstractTranslateField implements TranslateFieldInterface
{
    protected $deleted = self::NO;

    public function initialize(): void
    {
        parent::initialize();
        // @todo relationships
    }

    public function validation(): bool
    {
        $validator = $this->genericValidation();

        // @todo validations

        return $this->validate($validator);
    }
}
