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

use Phalcon\Di;
use Phalcon\Security;
use Zemit\Config\ConfigInterface;

trait Hash
{
    abstract public function getDI(): Di;
    
    /**
     * Hash string
     */
    public function hash(string $string, ?string $salt = null, ?string $workFactor = null): string
    {
        $config = $this->getDI()->get('config');
        assert($config instanceof ConfigInterface);
        
        $security = $this->getDI()->get('security');
        assert($security instanceof Security);
        
        // Get salt & workFactor
        $salt ??= $config->path('security.salt') ?? '';
        $workFactor ??= $config->path('security.workFactor') ?? 10;
        
        // return salted hash
        return $security->hash($salt . $string, $workFactor);
    }
    
    /**
     * Check hash
     */
    public function checkHash(?string $hash = null, ?string $string = null, int $maxPassLength = 0): bool
    {
        // hash empty, not valid
        if (empty($hash)) {
            return false;
        }
        
        // string empty not valid
        if (empty($string)) {
            return false;
        }
        
        $config = $this->getDI()->get('config');
        assert($config instanceof ConfigInterface);
        
        $security = $this->getDI()->get('security');
        assert($security instanceof Security);
        
        // Get salt
        $salt = $config->path('security.salt') ?? '';
        
        // check hash
        return $security->checkHash($salt . $string, $hash, $maxPassLength);
    }
}
