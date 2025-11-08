<?php

declare(strict_types=1);

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit Team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace PhalconKit\Mvc\Controller\Traits\Abstracts\Query;

use Phalcon\Support\Collection;

trait AbstractHaving
{
    abstract public function initializeHaving(): void;
    
    abstract public function setHaving(?Collection $having): void;
    
    abstract public function getHaving(): ?Collection;
}
