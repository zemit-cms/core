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
 * Zemit\Mvc\Model\Behavior\Transformable
 *
 * Allows to automatically update a model’s attribute saving the datetime when a
 * record is created or updated
 */
class Transformable extends Behavior
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
        
        foreach ($options as $field => $value) {
            $value = is_callable($value)? $value($model, $field) : $value;
            $model->writeAttribute($field, $value);
//            $model->assign([$field => $value]);
        }
    }
}
