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

use Zemit\Config\ConfigInterface;
use Zemit\Models\Audit;
use Zemit\Models\AuditDetail;
use Zemit\Models\User;
use Zemit\Mvc\Model\AbstractTrait\AbstractBehavior;
use Zemit\Mvc\Model\AbstractTrait\AbstractInjectable;

trait Blameable
{
    use AbstractBehavior;
    use AbstractInjectable;
    
    /**
     * Initializing Blameable
     */
    public function initializeBlameable(): void
    {
        $this->addBlameableBehavior();
    }
    
    /**
     * Blameable Audit Behavior
     */
    public function addBlameableBehavior(): void
    {
        $config = $this->getDI()->get('config');
        assert($config instanceof ConfigInterface);
        
        $this->addBehavior(new Behavior\Blameable([
            'auditClass' => $config->getModelClass(Audit::class),
            'auditDetailClass' => $config->getModelClass(AuditDetail::class),
            'userClass' => $config->getModelClass(User::class),
        ]));
    }
}
