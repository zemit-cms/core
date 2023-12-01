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

/**
 * Allow to enable or disable trait
 * on the current model instance ($progress)
 * or globally for every model instance ($staticProgress)
 */
trait ProgressTrait
{
    public bool $progress = false;
    public static bool $staticProgress = false;
    
    /**
     * Return true if the behavior is progress
     * on the current model instance
     */
    public function getProgress(): bool
    {
        return $this->progress;
    }
    
    /**
     * Set true to enable the behavior
     * on the current model instance
     */
    public function setProgress(bool $progress): void
    {
        $this->progress = $progress;
    }
    
    /**
     * Return true if the behavior is progress
     * globally for every model instance
     */
    public static function getStaticProgress(): bool
    {
        return self::$staticProgress;
    }
    
    /**
     * Set true to enable the behavior
     * globally for every model instance
     */
    public static function setStaticProgress(bool $staticProgress): void
    {
        self::$staticProgress = $staticProgress;
    }
    
    /**
     * Enable the behavior
     * on the current model instance
     */
    public function start(): void
    {
        $this->setProgress(true);
    }
    
    /**
     * Disable the behavior
     * on the current model instance
     */
    public function stop(): void
    {
        $this->setProgress(false);
    }
    
    /**
     * Enable the behavior
     * globally for every model instance
     */
    public static function staticStart(): void
    {
        self::setStaticProgress(true);
    }
    
    /**
     * Disable the behavior
     * globally for every model instance
     */
    public static function staticStop(): void
    {
        self::setStaticProgress(false);
    }
    
    /**
     * Return true if the behavior is in progress
     * on the current model instance and globally
     */
    public function inProgress(): bool
    {
        return $this->getProgress() || self::getStaticProgress();
    }
    
    /**
     * Return true if the behavior is started
     * on the current model instance and globally
     */
    public function isStarted(): bool
    {
        return $this->inProgress();
    }
    
    /**
     * Return true if the behavior is stopped
     * on the current model instance and globally
     */
    public function isStopped(): bool
    {
        return !$this->inProgress();
    }
}
