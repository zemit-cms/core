<?php

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit Team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PhalconKit\Mvc\Model\Interfaces;

use PhalconKit\Mvc\Model\Behavior\Security as SecurityBehavior;

interface SecurityInterface
{
    public function initializeSecurity(?array $options = null): void;
    
    public function setSecurityBehavior(SecurityBehavior $securityBehavior): void;
    
    public function getSecurityBehavior(): SecurityBehavior;
}
