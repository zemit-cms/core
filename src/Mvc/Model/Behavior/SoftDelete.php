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
