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

use Zemit\Models\Abstracts\WorkspaceLangAbstract;
use Zemit\Models\Interfaces\WorkspaceLangInterface;

/**
 * Class WorkspaceLang
 *
 * This class represents a WorkspaceLang object.
 * It extends the WorkspaceLangAbstract class and implements the WorkspaceLangInterface.
 */
class WorkspaceLang extends WorkspaceLangAbstract implements WorkspaceLangInterface
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
