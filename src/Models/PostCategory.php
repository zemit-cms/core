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

use Zemit\Models\Abstracts\PostCategoryAbstract;
use Zemit\Models\Interfaces\PostCategoryInterface;

/**
 * Class PostCategory
 *
 * This class represents a PostCategory object.
 * It extends the PostCategoryAbstract class and implements the PostCategoryInterface.
 */
class PostCategory extends PostCategoryAbstract implements PostCategoryInterface
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
