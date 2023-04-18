<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Di;

use Phalcon\Di;
use Phalcon\Di\DiInterface;

/**
 * @property \Zemit\Cli\Dispatcher|\Zemit\Mvc\Dispatcher|\Zemit\Dispatcher\DispatcherInterface|\Phalcon\Mvc\Dispatcher|\Phalcon\Mvc\DispatcherInterface $dispatcher
 * @property \Zemit\Cli\Router|\Zemit\Mvc\Router|\Zemit\Router\RouterInterface|\Phalcon\Mvc\Router|\Phalcon\Mvc\RouterInterface $router
 * @property \Phalcon\Url|\Phalcon\Url\UrlInterface $url
 * @property \Zemit\Http\Request|\Zemit\Http\RequestInterface|\Phalcon\Http\Request|\Phalcon\Http\RequestInterface $request
 * @property \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface $response
 * @property \Phalcon\Http\Response\Cookies|\Phalcon\Http\Response\CookiesInterface $cookies
 * @property \Zemit\Filter|\Phalcon\Filter $filter
 * @property \Phalcon\Flash\Direct $flash
 * @property \Phalcon\Flash\Session $flashSession
 * @property \Phalcon\Session\ManagerInterface $session
 * @property \Phalcon\Events\Manager|\Phalcon\Events\ManagerInterface $eventsManager
 * @property \Phalcon\Db\Adapter\AdapterInterface $db
 * @property \Zemit\Security|\Phalcon\Security $security
 * @property \Phalcon\Crypt|\Phalcon\CryptInterface $crypt
 * @property \Zemit\Tag|\Phalcon\Tag $tag
 * @property \Zemit\Escaper|\Phalcon\Escaper|\Phalcon\Escaper\EscaperInterface $escaper
 * @property \Phalcon\Annotations\Adapter\Memory|\Phalcon\Annotations\Adapter $annotations
 * @property \Phalcon\Mvc\Model\Manager|\Phalcon\Mvc\Model\ManagerInterface $modelsManager
 * @property \Phalcon\Mvc\Model\MetaData\Memory|\Phalcon\Mvc\Model\MetadataInterface $modelsMetadata
 * @property \Phalcon\Mvc\Model\Transaction\Manager|\Phalcon\Mvc\Model\Transaction\ManagerInterface $transactionManager
 * @property \Phalcon\Assets\Manager $assets
 * @property \Phalcon\Di|\Phalcon\Di\DiInterface $di
 * @property \Phalcon\Session\Bag|\Phalcon\Session\BagInterface $persistent
 * @property \Phalcon\Mvc\View|\Phalcon\Mvc\ViewInterface $view
 *
 * @property \Zemit\Bootstrap\Config $config
 * @property \Zemit\Bootstrap $bootstrap
 * @property \Zemit\Debug $debug
 * @property \Zemit\Identity $identity
 * @property \Zemit\Locale $locale
 * @property \Zemit\Utils $utils
 * @property \Zemit\Profiler $profiler
 * @property \Zemit\Logger $logger
 * @property \Zemit\Jwt $jwt
 * @property \Zemit\OpenAi $openAi
 * @property \Zemit\LoremIpsum $loremIpsum
 */
trait InjectableTrait
{
    public ?DiInterface $container;
    
    public function __get(string $name)
    {
        $container = $this->getDI();
        
        if ($name === 'di') {
            $this->{'di'} = $container;
            return $container;
        }
        
        if ($name === 'persistent') {
            $persistent = $container->get('sessionBag', [get_class($this)]);
            $this->{'persistent'} = $persistent;
            return $persistent;
        }
        
        if ($container->has($name)) {
            $service = $container->getShared($name);
            $this->{$name} = $service;
            return $service;
        }
        
        trigger_error('Access to undefined property `' . $name . '`');
    }
    
    public function __isset(string $name): bool
    {
        return $this->getDI()->has($name);
    }
    
    public function getDI(): DiInterface
    {
        if (!isset($this->container)) {
            $this->container = Di::getDefault();
        }
        
        return $this->container;
    }
    
    public function setDI(DiInterface $container)
    {
        $this->container = $container;
    }
}
