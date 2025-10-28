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

use Zemit\Models\Abstracts\AuditAbstract;
use Zemit\Models\Interfaces\AuditInterface;

/**
 * Class Audit
 *
 * This class represents a Audit object.
 * It extends the AuditAbstract class and implements the AuditInterface.
 */
class Audit extends AuditAbstract implements AuditInterface
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
