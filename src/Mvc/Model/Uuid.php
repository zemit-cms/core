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

use Phalcon\Security;
use Zemit\Mvc\Model\AbstractTrait\AbstractBehavior;
use Zemit\Mvc\Model\AbstractTrait\AbstractInjectable;
use Zemit\Mvc\Model\Behavior\Transformable;

trait Uuid
{
    use Options;
    use AbstractBehavior;
    use AbstractInjectable;
    
    public Transformable $uuidBehavior;
    
    /**
     * Initializing Uuid
     */
    public function initializeUuid(?array $options = null): void
    {
        $options ??= $this->getOptionsManager()->get('uuid') ?? [];
        $field = $options['field'] ?? 'uuid';
        
        $security = $this->getDI()->get('security');
        assert($security instanceof Security);
        
        $this->setUuidBehavior(new Transformable([
            'beforeValidationOnCreate' => [
                $field => function ($model, $field) use ($security) {
                    return $model->getAttribute($field) ?? $security->getRandom()->uuid();
                },
            ],
        ]));
    }
    
    /**
     * Set Uuid Behavior
     */
    public function setUuidBehavior(Transformable $uuidBehavior): void
    {
        $this->uuidBehavior = $uuidBehavior;
        $this->addBehavior($this->uuidBehavior);
    }
    
    /**
     * Get Uuid Behavior
     */
    public function getUuidBehavior(): Transformable
    {
        return $this->uuidBehavior;
    }
}
