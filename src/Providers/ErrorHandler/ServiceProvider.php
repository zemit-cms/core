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
 * Docs\Providers\ErrorHandler\ServiceProvider
 *
 * @package Docs\Providers\ErrorHandler
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

        $container->setShared(
            'errorHandler',
            function () use ($container) {
                $run = new Run();

                $mode = $container->bootstrap->getMode();

                switch ($mode) {
                    case 'normal':
                        if ($container->config->app->debug) {
                            $run->pushHandler($container->get('errorHandler::prettyPageHandler'));
                        } else {
                            $run->pushHandler($container->get('errorHandler::errorPageHandler'));
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

                $run->pushHandler($container->get('errorHandler::loggerHandler'));

                return $run;
            }
        );
    
        $container->get('errorHandler')->register();
    }
}
