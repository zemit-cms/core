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

namespace PhalconKit\Fractal;

use League\Fractal\TransformerAbstract;
use Phalcon\Di\InjectionAwareInterface;
use PhalconKit\Di\InjectableTrait;

/**
 * This class extends the TransformerAbstract class and implements the InjectionAwareInterface.
 * It also uses the InjectableTrait.
 */
class Transformer extends TransformerAbstract implements InjectionAwareInterface
{
    use InjectableTrait;
}
