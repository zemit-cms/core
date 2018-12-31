<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Providers\ErrorHandler;

use Phalcon\Di;
use Zemit\Exception\Handler\ErrorPageHandler;
use Zemit\Exception\Handler\LoggerHandler;
use InvalidArgumentException;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\DiInterface;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

/**
 * Zemit\Providers\ErrorHandler\ServiceProvider
 *
 * @package Zemit\Providers\ErrorHandler
 */
class ServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     *
     * @param DiInterface $container
     */
    public function register(DiInterface $container)
    {
        $container->setShared('errorHandler::loggerHandler', LoggerHandler::class);
        $container->setShared('errorHandler::prettyPageHandler', PrettyPageHandler::class);
        $container->setShared('errorHandler::errorPageHandler', ErrorPageHandler::class);
        
        $container->setShared('errorHandler', function() {
            $run = new Run();
            
            $mode = Di::getDefault()->get('bootstrap')->getMode();
            
            switch($mode) {
                case 'normal':
                    if (true) { //@TODO fetch from config
                        $run->pushHandler(Di::getDefault()->get('errorHandler::prettyPageHandler'));
                    } else {
                        $run->pushHandler(Di::getDefault()->get('errorHandler::errorPageHandler'));
                    }
                    break;
                case 'cli':
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
            
            $run->pushHandler(Di::getDefault()->get('errorHandler::loggerHandler'));
            return $run;
        });
        
        Di::getDefault()->get('errorHandler')->register();
    }
}
