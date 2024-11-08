<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Debug;

use Phalcon\Di\DiInterface;
use Phalcon\Support\Version;
use Zemit\Bootstrap;
use Zemit\Config\ConfigInterface;
use Zemit\Provider\AbstractServiceProvider;
use Zemit\Support\Debug;
use Zemit\Support\Php;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'debug';
    
    public function register(DiInterface $di): void
    {
        $causeCyclicError = $this->causeCyclicError();
        
        $di->setShared($this->getName(), function () use ($di, $causeCyclicError) {
            
            $bootstrap = $di->get('bootstrap');
            assert($bootstrap instanceof Bootstrap);
            
            $config = $di->get('config');
            assert($config instanceof ConfigInterface);
            
            $isEnabled = $config->path('app.debug') || $config->path('debug.enable');
            
            Php::debug($isEnabled);
            $debug = new Debug();
            
            if ($isEnabled && !$causeCyclicError && !$bootstrap->isCli()) {
                $debugConfig = $config->pathToArray('debug');
                
                $debug->listen($debugConfig['exceptions'] ?? true, $debugConfig['lowSeverity'] ?? false);
                $debug->setBlacklist($debugConfig['blacklist'] ?? []);
                $debug->setShowFiles($debugConfig['showFiles'] ?? true);
                $debug->setShowBackTrace($debugConfig['showBackTrace'] ?? true);
                $debug->setShowFileFragment($debugConfig['showFileFragment'] ?? true);
                
                if (is_string($debugConfig['uri'])) {
                    $debug->setUri($debugConfig['uri']);
                }
            }
            
            return $debug;
        });
    }
    
    public function causeCyclicError(): bool
    {
        return
            version_compare(PHP_VERSION, '8.0.0', '>=') &&
            version_compare((new Version())->get(), '5.0.0', '<');
    }
}
