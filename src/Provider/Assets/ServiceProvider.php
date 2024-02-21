<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Assets;

use Phalcon\Di\DiInterface;
use Phalcon\Html\Escaper\EscaperInterface;
use Phalcon\Html\TagFactory;
use Zemit\Assets\Manager;
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'assets';
    
    public function register(DiInterface $di): void
    {
        $escaper = $di->get('escaper');
        assert($escaper instanceof EscaperInterface);
        
        $tagFactory = new TagFactory($escaper); // @todo move Zemit\Tag to TagFactory
        
        $di->setShared($this->getName(), function () use ($tagFactory) {
            return new Manager($tagFactory);
        });
    }
}
