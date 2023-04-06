<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model\Behavior;

use Phalcon\Mvc\Model\Behavior;
use Phalcon\Mvc\ModelInterface;

/**
 * Allow to enable or disable trait
 */
trait SkippableTrait
{
    public bool $enabled = true;
    
    /**
     * Return true if the behavior is enabled
     * on the current model instance
     */
    public function getEnabled(): bool
    {
        return $this->enabled;
    }
    
    /**
     * Set true to enable the behavior
     * on the current model instance
     */
    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }
    
    /**
     * Enable the behavior
     * on the current model instance
     */
    public function enable(): void
    {
        $this->setEnabled(true);
    }
    
    /**
     * Disable the behavior
     * on the current model instance
     */
    public function disable(): void
    {
        $this->setEnabled(false);
    }
    
    /**
     * Return true if the behavior is enabled
     * on the current model instance
     */
    public function isEnabled(): bool
    {
        return $this->getEnabled();
    }
}
