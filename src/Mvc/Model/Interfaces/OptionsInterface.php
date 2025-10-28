<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Zemit\Mvc\Model\Interfaces;

use Zemit\Support\Options\ManagerInterface;

interface OptionsInterface
{
    public function initializeOptions(): void;
    
    public function getOptionsManager(): ManagerInterface;

    public function setOptionsManager(ManagerInterface $optionsManager): void;
}
