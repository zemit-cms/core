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

namespace PhalconKit\Mvc\Model\Interfaces;

use Phalcon\Mvc\EntityInterface;

interface AttributeInterface extends EntityInterface
{
    public function getAttribute(string $attribute): mixed;
        
    public function setAttribute(string $attribute, mixed $value): void;
}
