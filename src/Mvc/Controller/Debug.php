<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller;

trait Debug
{
    
    /**
     * Returns whether debug mode is enabled.
     *
     * @return bool True if debug mode is enabled, false otherwise.
     */
    public function isDebugEnabled(): bool
    {
        return $this->config->path('app.debug') ?? false;
    }
}
