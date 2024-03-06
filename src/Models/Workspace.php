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

use Zemit\Models\Abstracts\WorkspaceAbstract;
use Zemit\Models\Interfaces\WorkspaceInterface;

/**
 * Class Workspace
 *
 * This class represents a Workspace object.
 * It extends the WorkspaceAbstract class and implements the WorkspaceInterface.
 */
class Workspace extends WorkspaceAbstract implements WorkspaceInterface
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