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

use Zemit\Mvc\Model\Behavior\Security as SecurityBehavior;

interface SecurityInterface
{
    public function initializeSecurity(?array $options = null): void;
    
    public function setSecurityBehavior(SecurityBehavior $securityBehavior): void;
    
    public function getSecurityBehavior(): SecurityBehavior;
}
