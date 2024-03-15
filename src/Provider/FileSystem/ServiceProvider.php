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
use League\Flysystem\Local\LocalFilesystemAdapter;
use Phalcon\Di\DiInterface;
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'fileSystem';
    
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function ($root = null) use ($di) {

            $config = $di->get('config');
            $root ??= $config->path('app.dir.root') ?? getcwd();
            
            return new Filesystem(new LocalFilesystemAdapter($root));
        });
    }
}
