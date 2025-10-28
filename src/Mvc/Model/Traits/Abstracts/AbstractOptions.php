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

namespace Zemit\Mvc\Model\Traits\Abstracts;

use Zemit\Support\Options\ManagerInterface;

trait AbstractOptions
{
    abstract public function initializeOptions(): void;
    
    abstract public function getOptionsManager(): ManagerInterface;
    
    abstract public function setOptionsManager(ManagerInterface $optionsManager): void;
}
