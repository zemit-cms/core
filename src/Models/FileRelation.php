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

use Zemit\Models\Abstracts\FileRelationAbstract;
use Zemit\Models\Interfaces\FileRelationInterface;

/**
 * Class FileRelation
 *
 * This class represents a FileRelation model.
 * It extends the FileRelationAbstract class and implements the FileRelationInterface.
 */
class FileRelation extends FileRelationAbstract implements FileRelationInterface
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