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

use Phalcon\Di\DiInterface;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\Noop;
use Phalcon\Logger\Formatter\Line;
use Phalcon\Logger\Formatter\Json;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Zemit\Provider\Logger\ServiceProvider
 *
 * @package Zemit\Provider\Logger
 */
class ServiceProvider extends AbstractServiceProvider
{
    const DEFAULT_LOG_LEVEL = Logger::DEBUG;
    const DEFAULT_FORMAT = '[%date%][%type%] %message%';
    const DEFAULT_DATE = 'Y-m-d H:i:s';
    
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'logger';
    
    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function () use ($di) {
            $config = $di->get('config')->logger;
            $drivers = $config->driver;
            
            // Can be a string or an array
            if (!is_array($drivers)) {
                $drivers = [$drivers];
            }
            
            $adapters = [];
            foreach ($config->driver as $driver) {
                $options = $config->drivers->$driver;
                $adapter = $options->adapter;
                $name = $options->name;
                
                // driver
                $adapters[$driver] = new $adapter($name, $options);
                
                // json
                if ($config->default->formatter === 'json') {
    
                    // json formatter
                    $formatter = new Json();
                    $formatter->setDateFormat($options['date'] ? : self::DEFAULT_DATE);
                }
                
                // defualt formatter
                else {
                    
                    // line formatter
                    $formatter = new Line();
                    $formatter->setFormat($options['format'] ?: self::DEFAULT_FORMAT);
                    $formatter->setDateFormat($options['date'] ?: self::DEFAULT_DATE);
                }
                
                // set formatter
                $adapters[$driver]->setFormatter($formatter);
            }
            
            // logger
            $logger = new Logger('logger', $adapters);
            
            // default log level
            $logger->setLogLevel($config->default->logLevel ?? self::DEFAULT_LOG_LEVEL);
            
            return $logger;
        });
    }
}
