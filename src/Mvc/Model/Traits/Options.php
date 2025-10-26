<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model\Traits;

use Zemit\Support\Options\Manager;
use Zemit\Support\Options\ManagerInterface;

/**
 * The Options trait provides methods for managing options using an options manager.
 */
trait Options
{
    public ?ManagerInterface $optionsManager = null;
    
    /**
     * Initialize the Options Manager for the current instance
     *
     * @return void
     */
    public function initializeOptions(): void
    {
        $manager = new Manager();
        $this->setOptionsManager($manager);
    }
    
    /**
     * Get the Options Manager for the current instance
     *
     * @return ManagerInterface The Options Manager for the current instance
     */
    public function getOptionsManager(): ManagerInterface
    {
        if (!isset($this->optionsManager)){
            $this->initializeOptions();
        }
        
        assert($this->optionsManager instanceof ManagerInterface);
        return $this->optionsManager;
    }
    
    /**
     * Sets the options manager.
     *
     * @param ManagerInterface $optionsManager The options manager to be set.
     * 
     * @return void
     */
    public function setOptionsManager(ManagerInterface $optionsManager): void
    {
        $this->optionsManager = $optionsManager;
    }
}
