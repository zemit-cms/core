<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model;

use Zemit\Support\Options\Manager;

trait Options
{
    public Manager $optionsManager;
    
    /**
     * Initialize Options Manager
     */
    public function initializeOptions(): void
    {
        $manager = new Manager();
        $this->setOptionsManager($manager);
    }
    
    /**
     * Return the existing or a new Options Manager of the current instance
     */
    public function getOptionsManager(): Manager
    {
        return $this->optionsManager;
    }
    
    /**
     * Set an Options Manager for the current instance
     */
    public function setOptionsManager(Manager $optionsManager = null): void
    {
        $this->optionsManager = $optionsManager;
    }
}
