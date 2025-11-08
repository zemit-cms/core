<?php

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit Team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PhalconKit\Models;

use PhalconKit\Models\Abstracts\AuditAbstract;
use PhalconKit\Models\Interfaces\AuditInterface;

/**
 * Class Audit
 *
 * This class represents a Audit object.
 * It extends the AuditAbstract class and implements the AuditInterface.
 */
class Audit extends AuditAbstract implements AuditInterface
{
    #[\Override]
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
