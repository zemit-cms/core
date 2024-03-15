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

use Zemit\Models\Abstracts\TranslateFieldAbstract;
use Zemit\Models\Interfaces\TranslateFieldInterface;

/**
 * Class TranslateField
 *
 * This class represents a TranslateField object.
 * It extends the TranslateFieldAbstract class and implements the TranslateFieldInterface.
 */
class TranslateField extends TranslateFieldAbstract implements TranslateFieldInterface
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
