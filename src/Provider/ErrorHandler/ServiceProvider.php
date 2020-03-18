<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\ErrorHandler;

use Phalcon\Di;
use Phalcon\Di\DiInterface;
use Zemit\Provider\AbstractServiceProvider;
use Zemit\Exception\Handler\ErrorPageHandler;
use Zemit\Exception\Handler\LoggerHandler;
use InvalidArgumentException;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

/**
 * Zemit\Provider\ErrorHandler\ServiceProvider
 *
 * @package Zemit\Provider\ErrorHandler
 */
class ServiceProvider extends AbstractServiceProvider
{
    public $serviceName = 'errorHandler';
    
    /**
     * {@inheritdoc}
     *
     * @param DiInterface $container
     */
    public function register(DiInterface $container)
    {
        $serviceName = $this->getName();
        
        $container->setShared($serviceName . '::loggerHandler', LoggerHandler::class);
        $container->setShared($serviceName . '::prettyPageHandler', PrettyPageHandler::class);
        $container->setShared($serviceName . '::errorPageHandler', ErrorPageHandler::class);
        
        $container->setShared($serviceName, function() use ($serviceName, $container) {
            $run = new Run();
            
            $mode = $container->get('bootstrap')->getMode();
            
            switch($mode) {
                case 'normal':
                    if (true) { //@TODO fetch from config
                        $run->pushHandler($container->get($serviceName . '::prettyPageHandler'));
                    } else {
                        $run->pushHandler($container->get($serviceName . '::errorPageHandler'));
                    }
                    break;
                case 'cli':
                case 'console':
                    // @todo
                    break;
                default:
                    throw new InvalidArgumentException(
                        sprintf(
                            'Invalid application mode. Expected either "normal" or "cli". Got "%s".',
                            is_scalar($mode) ? $mode : var_export($mode, true)
                        )
                    );
            }
            
            $run->pushHandler($container->get($serviceName . '::loggerHandler'));
            return $run;
        });
        
        $container->get($serviceName)->register();
    }
}
