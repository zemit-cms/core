<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Fractal;

use League\Fractal\TransformerAbstract;
use Phalcon\Di\InjectionAwareInterface;
use Zemit\Di\InjectableTrait;
use Phalcon\Mvc\Model;

/**
 * This class is responsible for transforming a Model object into an array representation.
 */
class ModelTransformer extends TransformerAbstract implements InjectionAwareInterface
{
    use InjectableTrait;
    
    public function transform(Model $model): array
    {
        return $model->toArray();
    }
}
