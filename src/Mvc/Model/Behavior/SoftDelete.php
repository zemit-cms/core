<?php

declare(strict_types=1);

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit Team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace PhalconKit\Mvc\Model\Behavior;

use Phalcon\Mvc\Model\Behavior;
use Phalcon\Mvc\ModelInterface;
use PhalconKit\Mvc\Model\Behavior\Traits\SkippableTrait;

/**
 * {@inheritDoc}
 */
class SoftDelete extends Behavior\SoftDelete
{
    use SkippableTrait;
    
    public function setField(string $field): void
    {
        $this->options['field'] = $field;
    }
    
    public function getField(): string
    {
        return $this->options['field'];
    }
    
    public function setValue(int $value): void
    {
        $this->options['value'] = $value;
    }
    
    public function getValue(): int
    {
        return $this->options['value'];
    }
    
    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $this->setField($options['field'] ?? 'deleted');
        $this->setValue($options['value'] ?? 1);
    }
    
    #[\Override]
    public function notify(string $type, ModelInterface $model): ?bool
    {
        if (!$this->isEnabled()) {
            return null;
        }
        
        parent::notify($type, $model);
        return null;
    }
}
