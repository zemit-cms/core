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

use Phalcon\Db\RawValue;
use Phalcon\Encryption\Security;
use Zemit\Mvc\Model\AbstractTrait\AbstractBehavior;
use Zemit\Mvc\Model\AbstractTrait\AbstractInjectable;
use Zemit\Mvc\Model\Behavior\Transformable;

trait Uuid
{
    use AbstractBehavior;
    use AbstractInjectable;
    use Options;
    use Behavior;
    
    /**
     * Initializing Uuid
     */
    public function initializeUuid(?array $options = null): void
    {
        $options ??= $this->getOptionsManager()->get('uuid') ?? [];
        
        $field = $options['field'] ?? 'uuid';
        $native = $options['native'] ?? true;
        $binary = $options['binary'] ?? true;
        
        $security = $this->getDI()->get('security');
        assert($security instanceof Security);
        
        $this->setUuidBehavior(new Transformable([
            'beforeValidationOnCreate' => [
                $field => function ($model, $field) use ($security, $native, $binary) {
                    return $model->getAttribute($field) ?? $native
                        ? ($binary
                            ? new RawValue('UUID_TO_BIN(UUID())')
                            : new RawValue('UUID()')
                        )
                        : ($binary
                            ? $this->getBinaryUuid($security->getRandom()->uuid())
                            : $security->getRandom()->uuid()
                        );
                },
            ],
            'afterFetch' => [
                $field => function ($model, $field) use ($native, $binary) {
                    $value = $model->getAttribute($field);
                    if ($binary && !empty($value)) {
                        $hex = bin2hex($value);
                        $uuid = sprintf(
                            '%s-%s-%s-%s-%s',
                            substr($hex, 0, 8),
                            substr($hex, 8, 4),
                            substr($hex, 12, 4),
                            substr($hex, 16, 4),
                            substr($hex, 20, 12)
                        );
                        $this->setAttribute($field, $uuid);
                        return $uuid;
                    }
                },
            ],
        ]));
    }
    
    /**
     * Get a binary representation of UUID
     *
     * @param string $uuid
     * @return string
     */
    private function getBinaryUuid($uuid)
    {
        return pack('h*', str_replace('-', '', $uuid));
    }
    
    /**
     * Set Uuid Behavior
     */
    public function setUuidBehavior(Transformable $uuidBehavior): void
    {
        $this->setBehavior('uuid', $uuidBehavior);
    }
    
    /**
     * Get Uuid Behavior
     */
    public function getUuidBehavior(): Transformable
    {
        $behavior = $this->getBehavior('uuid');
        assert($behavior instanceof Transformable);
        return $behavior;
    }
}
