<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\VoltTemplate;

use Phalcon\Di\DiInterface;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Mvc\ViewBaseInterface;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Zemit\Provider\VoltTemplate\ServiceProvider
 *
 * @package Zemit\Provider\VoltTemplate
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'volt';

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function register(\Phalcon\Di\DiInterface $container) : void
    {
        $service = function (ViewBaseInterface $view, DiInterface $di = null) use ($container) {
            $volt = new Volt($view, $di ?: $container);

            $volt->setOptions(
                [
                    'compiledPath'  => function ($path) {
                        $path     = trim(substr($path, strlen(dirname(app_path()))), '\\/');
                        $filename = basename(str_replace(['\\', '/'], '_', $path), '.volt') . '.php';
                        $cacheDir = cache_path('volt');

                        if (!is_dir($cacheDir)) {
                            @mkdir($cacheDir, 0755, true);
                        }

                        return $cacheDir . DIRECTORY_SEPARATOR . $filename;
                    },
                    'compileAlways' => environment('development') || env('APP_DEBUG', false),
                ]
            );

            $volt->getCompiler()->addExtension(new VoltFunctions());

            return $volt;
        };
    
        $container->setShared($this->getName(), $service);
    }
}
