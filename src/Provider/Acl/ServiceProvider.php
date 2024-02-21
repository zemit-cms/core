<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Acl;

use Phalcon\Di\DiInterface;
use Zemit\Acl\Acl;
use Zemit\Config\ConfigInterface;
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'acl';
    
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function () use ($di) {
    
            // config
            $config = $di->get('config');
            assert($config instanceof ConfigInterface);
            
            // acl config
            $aclConfig = $config->pathToArray('acl', []);
            
            // permissions config
            $permissionsConfig = $config->pathToArray('permissions', []);
            
            // acl options
            $options = array_merge($aclConfig, ['permissions' => $permissionsConfig]);
            
            return new Acl($options);
        });
    }
}
