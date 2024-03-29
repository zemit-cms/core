<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Http;

/**
 * {@inheritDoc}
 */
interface RequestInterface extends \Phalcon\Http\RequestInterface
{
    public function isCors(): bool;
    
    public function isPreflight(): bool;
    
    public function isSameOrigin(): bool;
    
    public function toArray(): array;
}
