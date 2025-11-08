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

namespace PhalconKit\Mvc\Controller\Behavior\Skip;

class SkipGroup
{
    /**
     * Stop operation
     * @return false
     */
    public function getGroup(): bool
    {
        return false;
    }
}
