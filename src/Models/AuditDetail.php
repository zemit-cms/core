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

use PhalconKit\Models\Abstracts\AuditDetailAbstract;
use PhalconKit\Models\Interfaces\AuditDetailInterface;

/**
 * Class AuditDetail
 *
 * This class represents a AuditDetail object.
 * It extends the AuditDetailAbstract class and implements the AuditDetailInterface.
 */
class AuditDetail extends AuditDetailAbstract implements AuditDetailInterface
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
