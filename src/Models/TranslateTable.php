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

use Zemit\Models\Abstracts\TranslateTableAbstract;
use Zemit\Models\Interfaces\TranslateTableInterface;

/**
 * Class TranslateTable
 *
 * This class represents a TranslateTable object.
 * It extends the TranslateTableAbstract class and implements the TranslateTableInterface.
 */
class TranslateTable extends TranslateTableAbstract implements TranslateTableInterface
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