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

class Snapshot extends Behavior
{
    use SkippableTrait;
    
    public function notify(string $type, ModelInterface $model): ?bool
    {
        if (!$this->isEnabled()) {
            return null;
        }
        
        if ($type === 'beforeCreate') {
            $this->beforeCreate($model);
        }
        
        return null;
    }
    
    public function beforeCreate(ModelInterface $model): void
    {
        $model->setSnapshotData($model->toArray());
    }
}
