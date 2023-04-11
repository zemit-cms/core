<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model\Behavior;

use Phalcon\Mvc\Model\Behavior;
use Phalcon\Mvc\ModelInterface;

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
    
    /**
     * @return mixed
     */
    public function notify(string $type, ModelInterface $model)
    {
        if (!$this->isEnabled()) {
            return;
        }
        
        return parent::notify($type, $model);
    }
}
