<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Logger;

use Phalcon\Config\ConfigInterface;
use Phalcon\Di\DiInterface;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\Noop;
use Phalcon\Logger\Formatter\Line;
use Phalcon\Logger\Formatter\Json;
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    public const DEFAULT_LOG_LEVEL = Logger::DEBUG;
    
    public const DEFAULT_FORMAT = '[%date%][%type%] %message%';
    
    public const DEFAULT_DATE = 'Y-m-d H:i:s';
    
    protected string $serviceName = 'logger';
    
    public function register(DiInterface $di): void
    {
        $config = $di->get('config');
        assert($config instanceof ConfigInterface);
    
        $loggerConfig = (array)$config->path('logger');
        
        $di->setShared($this->getName(), function () use ($loggerConfig) {
            
            // Can be a string or an array
            if (!is_array($loggerConfig['driver'])) {
                $loggerConfig['driver'] = [$loggerConfig['driver']];
            }
            
            $adapters = [];
            foreach ($loggerConfig['driver'] as $driver) {
                
                $defaultOptions = $loggerConfig['default'];
                $driverOptions = $loggerConfig['drivers'][$driver];
                $options = array_merge($defaultOptions, $driverOptions);
                
                $adapter = $options['adapter'];
                assert(class_exists($adapter));
                
                $filename = $options['filename'] ?: $driver;
                if (!is_array($filename)) {
                    $filename = [$filename];
                }
                
                // json
                if ($loggerConfig['default']['formatter'] === 'json') {
                    
                    // json formatter
                    $formatter = new Json();
                    $formatter->setDateFormat($options['date'] ?: self::DEFAULT_DATE);
                }
                
                // default formatter
                else {
                    
                    // line formatter
                    $formatter = new Line();
                    $formatter->setFormat($options['format'] ?: self::DEFAULT_FORMAT);
                    $formatter->setDateFormat($options['date'] ?: self::DEFAULT_DATE);
                }
                
                foreach ($filename as $file) {
                    $path = $options['path'] . $file . '.log';
                    
                    // driver
                    $adapters[$file] = new $adapter($path, $options);
                    
                    // set formatter
                    $adapters[$file]->setFormatter($formatter);
                }
            }
            
            // logger
            $logger = new Logger('logger', $adapters);
            
            // default log level
            $logLevel = $loggerConfig['default']['logLevel'] ?? self::DEFAULT_LOG_LEVEL;
            $logger->setLogLevel($logLevel);
            
            return $logger;
        });
    }
}
