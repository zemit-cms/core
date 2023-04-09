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

use Phalcon\Mvc\ModelInterface;
use Phalcon\Mvc\Model\Behavior;

class Snapshot extends Behavior
{
    use SkippableTrait;
    
    public function notify(string $type, ModelInterface $model): void
    {
        if (!$this->isEnabled()) {
            return;
        }
        
        if ($type === 'beforeCreate') {
            $this->beforeCreate($model);
        }
    }
    
    public function beforeCreate(ModelInterface $model): void
    {
        $model->setSnapshotData($model->toArray());
    }
}
