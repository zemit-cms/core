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

namespace Zemit\Mvc\Model\Interfaces;

use Phalcon\Mvc\EntityInterface;

interface AttributeInterface extends EntityInterface
{
    public function getAttribute(string $attribute): mixed;
        
    public function setAttribute(string $attribute, mixed $value): void;
}
