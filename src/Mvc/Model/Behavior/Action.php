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

namespace Zemit\Mvc\Model\Behavior;

use Phalcon\Mvc\Model\Behavior;
use Phalcon\Mvc\ModelInterface;
use Zemit\Mvc\Model\Behavior\Traits\SkippableTrait;

class Action extends Behavior
{
    use SkippableTrait;
    
    /**
     * @return void
     */
    #[\Override]
    public function notify(string $type, ModelInterface $model)
    {
        if (!$this->isEnabled()) {
            return;
        }
        
        if (!$this->mustTakeAction($type)) {
            return;
        }

        $options = $this->getOptions($type);
        if (empty($options)) {
            return;
        }

        foreach ($options as $action => $value) {
            assert(is_callable($value));
            $value($model, $action);
        }
    }
}
