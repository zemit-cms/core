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
use Phalcon\Di;
use Phalcon\Messages\Message;
use Phalcon\Mvc\ModelInterface;
use Phalcon\Mvc\Model\Behavior;

class Action extends Behavior
{
    use SkippableTrait;
    
    /**
     * @return void|null
     */
    public function notify(string $type, ModelInterface $model)
    {
        if (!$this->isEnabled()) {
            return;
        }
        
        if (!$this->mustTakeAction($type)) {
            return null;
        }

        $options = $this->getOptions($type);
        if (empty($options)) {
            return;
        }

        foreach ($options as $action => $value) {
            $value = is_callable($value) ? $value($model, $action) : $value;
        }
    }
}
