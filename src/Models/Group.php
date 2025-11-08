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

use PhalconKit\Models\Abstracts\GroupAbstract;
use PhalconKit\Models\Interfaces\GroupInterface;

/**
 * Class Group
 *
 * This class represents a Group object.
 * It extends the GroupAbstract class and implements the GroupInterface.
 */
class Group extends GroupAbstract implements GroupInterface
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
