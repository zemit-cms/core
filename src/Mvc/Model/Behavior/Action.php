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

/**
 * Class Action
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Mvc\Model\Behavior
 */
class Action extends Behavior
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
    
        foreach ($options as $action => $value) {
            $value = is_callable($value)? $value($model, $action) : $value;
        }
    }
}
