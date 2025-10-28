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

use Phalcon\Db\RawValue;
use Phalcon\Mvc\EntityInterface;
use Zemit\Encryption\Security;
use Zemit\Mvc\Model\Behavior\Transformable;
use Zemit\Mvc\Model\Traits\Abstracts\AbstractBehavior;
use Zemit\Mvc\Model\Traits\Abstracts\AbstractInjectable;
use Zemit\Mvc\Model\Traits\Abstracts\AbstractOptions;

trait Uuid
{
    use AbstractBehavior;
    use AbstractInjectable;
    use AbstractOptions;
    
    /**
     * Initializing Uuid
     */
    public function initializeUuid(?array $options = null): void
    {
        $options ??= $this->getOptionsManager()->get('uuid') ?? [];
        
        $field = $options['field'] ?? 'uuid';
        $native = $options['native'] ?? false;
        $binary = $options['binary'] ?? false;
        
        $security = $this->getDI()->get('security');
        assert($security instanceof Security);
        
        $this->setUuidBehavior(new Transformable([
            'beforeValidationOnCreate' => [
                $field => function (EntityInterface $model, string $field) use ($security, $native, $binary) {
                    return $model->readAttribute($field) ?? $native
                        ? ($binary
                            ? new RawValue('UUID_TO_BIN(UUID())')
                            : new RawValue('UUID()')
                        )
                        : ($binary
                            ? $this->getBinaryUuid($security->getRandom()->uuidv7())
                            : $security->getRandom()->uuidv7()
                        );
                },
            ],
//            'beforeValidation' => [
//                $field => function (EntityInterface $model, string $field) use ($security, $binary) {
//                    if ($binary) {
//                        // uuid field should remain unchanged
//                        return new RawValue('`' . $field . '`');
//                    }
//                },
//            ],
//            'afterFetch' => [
//                $field => function (EntityInterface $model, string $field) use ($binary) {
//                    // $native not yet supported while fetching
//                    $value = $model->readAttribute($field);
//                    if ($binary && !empty($value)) {
//                        $hex = bin2hex($value);
//                        return sprintf(
//                            '%s-%s-%s-%s-%s',
//                            substr($hex, 0, 8),
//                            substr($hex, 8, 4),
//                            substr($hex, 12, 4),
//                            substr($hex, 16, 4),
//                            substr($hex, 20, 12)
//                        );
//                    }
//                    return $value;
//                },
//            ],
        ]));
    }
    
    /**
     * Get Binary Uuid
     *
     * @param string $uuid The UUID string to convert to binary representation
     * @return string The binary representation of the given UUID
     */
    private function getBinaryUuid(string $uuid): string
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
