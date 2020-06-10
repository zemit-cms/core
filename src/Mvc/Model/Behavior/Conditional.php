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

use Closure;
use Phalcon\Mvc\ModelInterface;
use Phalcon\Mvc\Model\Behavior;

/**
 * Zemit\Mvc\Model\Behavior\Conditional
 *
 * Allows to automatically update a model’s attribute saving the datetime when a
 * record is created or updated
 */
class Conditional extends Behavior
{
    /**
     * Listens for notifications from the models manager
     *
     * @param string $type Event Type
     * @param ModelInterface $model Model
     *
     * @return void|null
     */
    public function notify(string $type, ModelInterface $model)
    {
        if (!$this->mustTakeAction($type)) {
            return null;
        }
        
        $options = $this->getOptions($type);
        
        if (empty($options)) {
            return;
        }
    
        $field = $this->getOption('field', $options, [$type, $model]);
        $condition = $this->getOption('condition', $options, [$type, $model, $field]);
        if ($condition) {
            $value = $this->getOption('value', $options, [$type, $model, $field]);
            $transformedValue = $this->getOption('transform', $options, [$type, $model, $field, $value]);
            $model->assign([$field => $transformedValue]);
        }
    }
    
    /**
     * @param string $key
     * @param array $options
     * @param array|null $params
     *
     * @return mixed|null
     */
    public function getOption(string $key, array $options, array $params = null)
    {
        $ret = $options[$key] ?? null;
        
        if (is_callable($ret)) {
            $ret = $ret(...$params);
        }
        
        return $ret;
    }
}
