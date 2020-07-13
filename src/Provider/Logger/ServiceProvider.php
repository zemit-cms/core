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
use Zemit\Provider\AbstractServiceProvider;

/**
 * Zemit\Provider\Logger\ServiceProvider
 *
 * @package Zemit\Provider\Logger
 */
class ServiceProvider extends AbstractServiceProvider
{
    const DEFAULT_LEVEL = 'debug';
    const DEFAULT_FORMAT = '[%date%][%type%] %message%';
    const DEFAULT_DATE = 'Y-m-d H:i:s';
    
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'logger';
    
    protected $logLevels = [
        'emergency' => Logger::EMERGENCY,
        'critical' => Logger::CRITICAL,
        'alert' => Logger::ALERT,
        'error' => Logger::ERROR,
        'warning' => Logger::WARNING,
        'notice' => Logger::NOTICE,
        'info' => Logger::INFO,
        'debug' => Logger::DEBUG,
        'custom' => Logger::CUSTOM,
    ];
    
    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $logLevels = $this->logLevels;
        
        $di->setShared($this->getName(), function ($filename = null, $format = null) use ($logLevels, $di) {
            $config = $di->get('config')->logger;
            
            // Setting up the log level
            if (empty($config->level)) {
                $level = self::DEFAULT_LEVEL;
            } else {
                $level = strtolower($config->level);
            }
            
            if (!array_key_exists($level, $logLevels)) {
                $level = Logger::DEBUG;
            } else {
                $level = $logLevels[$level];
            }
            
            // Setting up date format
            if (empty($config->date)) {
                $date = self::DEFAULT_DATE;
            } else {
                $date = $config->date;
            }
            
            // Format setting up
            if (empty($format)) {
                if (!isset($config->format)) {
                    $format = self::DEFAULT_FORMAT;
                } else {
                    $format = $config->format;
                }
            }
            
            // Setting up the filename
            $filename = trim($filename ? : $config->filename, '\\/');
            
            if (!strpos($filename, '.log')) {
                $filename = rtrim($filename, '.') . '.log';
            }
            
            $logger = new Noop(rtrim($config->path, '\\/') . DIRECTORY_SEPARATOR . $filename);
            
            $logger->setFormatter(new Line($format, $date));
            $logger->setLogLevel($level);
            
            return $logger;
        });
    }
}
