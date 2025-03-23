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
use Zemit\Mvc\Model\Behavior\Traits\SkippableTrait;

/**
 * Zemit\Mvc\Model\Traits\Behavior\Conditional
 *
 * Allows to automatically update a model’s attribute saving the datetime when a
 * record is created or updated
 */
class Conditional extends Behavior
{
    use SkippableTrait;
    
    /**
     * Listens for notifications from the models manager
     */
    public function notify(string $type, ModelInterface $model): ?bool
    {
        if (!$this->isEnabled()) {
            return null;
        }
        
        if (!$this->mustTakeAction($type)) {
            return null;
        }

        $options = $this->getOptions($type);
        if (empty($options)) {
            return null;
        }

        $field = $this->getOption('field', $options, [$type, $model]);
        $condition = $this->getOption('condition', $options, [$type, $model, $field]);
        
        if (!empty($field) && is_string($field) && $condition === true) {
            $value = $this->getOption('value', $options, [$type, $model, $field]);
            $transformedValue = $this->getOption('transform', $options, [$type, $model, $field, $value]);
            $model->assign([$field => $transformedValue]);
        }
        
        return true;
    }

    /**
     * @param string $key
     * @param array $options
     * @param array|null $params
     *
     * @return mixed|null
     */
    public function getOption(string $key, array $options, ?array $params = null): mixed
    {
        $ret = $options[$key] ?? null;
        if (is_callable($ret)) {
            $ret = $ret(...$params);
        }

        return $ret;
    }
}
