<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Support;

/**
 * Class Helper
 *
 * This class is responsible for providing helper methods and functions.
 */
class Helper extends \Phalcon\Di\Injectable
{
    public function getHelper(): HelperFactory
    {
        if ($this->container) {
            $helper = $this->getDI()->get('helper');
            
            if ($helper) {
                return $helper;
            }
        }
        
        return new HelperFactory();
    }
    
    public static function __callStatic(string $name, array $arguments): mixed
    {
        return (new self())->getHelper()->$name(...$arguments);
    }
}
