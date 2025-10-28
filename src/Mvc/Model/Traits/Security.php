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

namespace Zemit\Mvc\Model\Traits;

use Zemit\Mvc\Model\Behavior\Security as SecurityBehavior;
use Zemit\Mvc\Model\Traits\Abstracts\AbstractBehavior;
use Zemit\Mvc\Model\Traits\Abstracts\AbstractOptions;

/**
 * The Security trait provides methods to handle security-related functionalities.
 */
trait Security
{
    use AbstractBehavior;
    use AbstractOptions;
    
    /**
     * Initializes the security
     *
     * @param array|null $options An optional array of security options. If not provided,
     *                            the method will attempt to fetch the options from the options manager.
     *                            If no options are found, an empty array will be used.
     *
     * @return void
     */
    public function initializeSecurity(?array $options = null): void
    {
        $options ??= $this->getOptionsManager()->get('security') ?? [];
        
        $this->setSecurityBehavior(new SecurityBehavior($options));
    }
    
    /**
     * Sets the security behavior
     *
     * @param SecurityBehavior $securityBehavior The security behavior to set.
     *
     * @return void
     */
    public function setSecurityBehavior(SecurityBehavior $securityBehavior): void
    {
        $this->setBehavior('security', $securityBehavior);
    }
    
    /**
     * Retrieves the security behavior
     *
     * @return SecurityBehavior The security behavior instance.
     */
    public function getSecurityBehavior(): SecurityBehavior
    {
        $behavior = $this->getBehavior('security');
        assert($behavior instanceof SecurityBehavior);
        return $behavior;
    }
}
