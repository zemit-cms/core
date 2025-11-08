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

use PhalconKit\Mvc\Model\Behavior\Transformable;

interface SlugInterface
{
    public function initializeSlug(?array $options = null): void;
    
    public function setSlugBehavior(Transformable $slugBehavior): void;
    
    public function getSlugBehavior(): Transformable;
}
