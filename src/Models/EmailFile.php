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

use Zemit\Models\Abstracts\EmailFileAbstract;
use Zemit\Models\Interfaces\EmailFileInterface;

/**
 * Class EmailFile
 *
 * This class represents a EmailFile model.
 * It extends the EmailFileAbstract class and implements the EmailFileInterface.
 */
class EmailFile extends EmailFileAbstract implements EmailFileInterface
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