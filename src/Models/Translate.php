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

use Zemit\Models\Abstracts\TranslateAbstract;
use Zemit\Models\Interfaces\TranslateInterface;

/**
 * Class Translate
 *
 * This class represents a Translate object.
 * It extends the TranslateAbstract class and implements the TranslateInterface.
 */
class Translate extends TranslateAbstract implements TranslateInterface
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