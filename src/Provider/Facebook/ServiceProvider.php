<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\FileSystem;

use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use Phalcon\Di\DiInterface;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Zemit\Provider\FileSystem\ServiceProvider
 *
 * @package Zemit\Provider\FileSystem
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'oauth2-github';
    
    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function($root = null) {
            if ($root === null) {
                $root = dirname(app_path());
            }
            
            return new Filesystem(new Local($root));
        });
    }
}
