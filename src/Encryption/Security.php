<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Encryption;

use Phalcon\Encryption\Security as PhalconSecurity;
use Zemit\Config\ConfigInterface;

/**
 * {@inheritDoc}
 */
class Security extends PhalconSecurity
{
    public function getConfig(): ConfigInterface
    {
        return $this->getDI()->get('config');
    }
    
    public function hash(string $password, array $options = []) : string
    {
        if (in_array($this->getDefaultHash(), [
            PhalconSecurity::CRYPT_ARGON2I,
            PhalconSecurity::CRYPT_ARGON2ID
        ])) {
            $defaultOptions = $this->getConfig()->pathToArray('security.argon2') ?? [];
            $options['memory_cost'] ??= $defaultOptions['memoryCost'];
            $options['time_cost'] ??= $defaultOptions['timeCost'];
            $options['threads'] ??= $defaultOptions['threads'];
        }
        
        return parent::hash($password, $options);
    }
}
