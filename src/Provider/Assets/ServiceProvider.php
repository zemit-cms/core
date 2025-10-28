<?php

declare(strict_types=1);

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
use Zemit\Html\TagFactory;
use Zemit\Assets\Manager;
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'assets';
    
    #[\Override]
    public function register(DiInterface $di): void
    {
        $escaper = $di->get('escaper');
        assert($escaper instanceof EscaperInterface);
        
        // @todo set tag factory as tag service and use service instead
//        $tag = $di->get('tag');
//        assert($tag instanceof TagFactory);
        $tag = new TagFactory($escaper);
        
        $di->setShared($this->getName(), function () use ($tag) {
            return new Manager($tag);
        });
    }
}
