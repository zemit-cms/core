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

use Zemit\Models\Abstracts\AuditDetailAbstract;
use Zemit\Models\Interfaces\AuditDetailInterface;

/**
 * Class AuditDetail
 *
 * This class represents a AuditDetail model.
 * It extends the AuditDetailAbstract class and implements the AuditDetailInterface.
 */
class AuditDetail extends AuditDetailAbstract implements AuditDetailInterface
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