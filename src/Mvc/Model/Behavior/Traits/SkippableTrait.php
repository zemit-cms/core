<?php

declare(strict_types=1);

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model\Behavior\Traits;

/**
 * Allow to enable or disable trait
 * on the current model instance ($enabled)
 * or globally for every model instance ($staticEnabled)
 */
trait SkippableTrait
{
    public bool $enabled = true;
    public static bool $staticEnabled = true;
    
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
     * Return true if the behavior is enabled
     * globally for every model instance
     */
    public static function getStaticEnabled(): bool
    {
        return self::$staticEnabled;
    }
    
    /**
     * Set true to enable the behavior
     * globally for every model instance
     */
    public static function setStaticEnabled(bool $staticEnabled): void
    {
        self::$staticEnabled = $staticEnabled;
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
     * Enable the behavior
     * globally for every model instance
     */
    public static function staticEnable(): void
    {
        self::setStaticEnabled(true);
    }
    
    /**
     * Disable the behavior
     * globally for every model instance
     */
    public static function staticDisable(): void
    {
        self::setStaticEnabled(false);
    }
    
    /**
     * Return true if the behavior is enabled
     * on the current model instance and globally
     */
    public function isEnabled(): bool
    {
        return $this->getEnabled() && self::getStaticEnabled();
    }
    
    /**
     * Return true if the behavior is enabled
     * on the current model instance and globally
     */
    public function isDisabled(): bool
    {
        return !$this->isEnabled();
    }
}
