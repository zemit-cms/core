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

use PhalconKit\Models\Abstracts\FileRelationAbstract;
use PhalconKit\Models\Interfaces\FileRelationInterface;

/**
 * Class FileRelation
 *
 * This class represents a FileRelation object.
 * It extends the FileRelationAbstract class and implements the FileRelationInterface.
 */
class FileRelation extends FileRelationAbstract implements FileRelationInterface
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
