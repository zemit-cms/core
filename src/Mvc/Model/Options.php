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

use Zemit\Support\OptionsManager;

trait Options
{
    public ?OptionsManager $optionsManager = null;
    
    /**
     * Return the existing or a new OptionsManager of the current instance
     */
    public function getOptionsManager(): OptionsManager
    {
        if (!isset($this->optionsManager)) {
            $this->setOptionsManager(new OptionsManager());
        }
        return $this->optionsManager;
    }
    
    /**
     * Set an OptionsManager for the current instance
     */
    public function setOptionsManager(OptionsManager $optionsManager = null): void
    {
        $this->optionsManager = $optionsManager;
    }
}
