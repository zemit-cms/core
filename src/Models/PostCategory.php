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

use PhalconKit\Models\Abstracts\PostCategoryAbstract;
use PhalconKit\Models\Interfaces\PostCategoryInterface;

/**
 * Class PostCategory
 *
 * This class represents a PostCategory object.
 * It extends the PostCategoryAbstract class and implements the PostCategoryInterface.
 */
class PostCategory extends PostCategoryAbstract implements PostCategoryInterface
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
