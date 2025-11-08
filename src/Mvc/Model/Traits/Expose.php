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

namespace PhalconKit\Mvc\Model\Traits;

use PhalconKit\Support\Exposer\Exposer;

trait Expose
{
    public function expose(?array $columns = null, ?bool $expose = null, ?bool $protected = null): array
    {
        $builder = Exposer::createBuilder($this, $columns, $expose, $protected);
        $expose = Exposer::expose($builder);
        return is_array($expose) ? $expose : [];
    }
}
