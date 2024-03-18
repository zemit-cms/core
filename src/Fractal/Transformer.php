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

/**
 * This class extends the TransformerAbstract class and implements the InjectionAwareInterface.
 * It also uses the InjectableTrait.
 */
class Transformer extends TransformerAbstract implements InjectionAwareInterface
{
    use InjectableTrait;
}
