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

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior;
use Phalcon\Mvc\ModelInterface;
use PhalconKit\Mvc\Model\Behavior\Traits\SkippableTrait;

class Snapshot extends Behavior
{
    use SkippableTrait;
    
    #[\Override]
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
        assert($model instanceof Model);
        $model->setSnapshotData($model->toArray());
    }
}
