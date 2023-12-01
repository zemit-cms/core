<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model;

use Phalcon\Mvc\ModelInterface;
use Zemit\Support\Exposer\Exposer;

trait Expose
{
    /**
     * @todo refactor expose system
     * @return mixed
     */
    public function expose(?array $columns = null, ?bool $expose = null, ?bool $protected = null)
    {
        assert($this instanceof ModelInterface);
        $exposeBuilder = Exposer::createBuilder($this, $columns, $expose, $protected);
        return Exposer::expose($exposeBuilder);
    }
}
