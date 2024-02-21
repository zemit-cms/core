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

use Zemit\Mvc\Model\AbstractTrait\AbstractBehavior;
use Zemit\Mvc\Model\AbstractTrait\AbstractInjectable;
use Zemit\Mvc\Model\Behavior\Security as SecurityBehavior;

trait Security
{
    use AbstractInjectable;
    use AbstractBehavior;
    use Options;
    
    /**
     * Initializing Security
     */
    public function initializeSecurity(?array $options = null): void
    {
        $options ??= $this->getOptionsManager()->get('security') ?? [];
        
        $this->addBehavior(new SecurityBehavior($options));
    }
    
    /**
     * Set Security Behavior
     */
    public function setSecurityBehavior(SecurityBehavior $securityBehavior): void
    {
        $this->setBehavior('security', $securityBehavior);
    }
    
    /**
     * Get Security Behavior
     */
    public function getSecurityBehavior(): SecurityBehavior
    {
        $behavior = $this->getBehavior('security');
        assert($behavior instanceof SecurityBehavior);
        return $behavior;
    }
}
