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

use Phalcon\Di\DiInterface;

/**
 * Trait AbstractInjectable
 *
 * This trait provides a common trait for traits that are injectable
 * and depend on a dependency injection container.
 *
 * @property \Zemit\Cli\Dispatcher|\Zemit\Mvc\Dispatcher|\Zemit\Dispatcher\DispatcherInterface|\Phalcon\Mvc\Dispatcher|\Phalcon\Mvc\DispatcherInterface $dispatcher
 * @property \Zemit\Cli\Router|\Zemit\Mvc\Router|\Zemit\Router\RouterInterface|\Phalcon\Mvc\Router|\Phalcon\Mvc\RouterInterface $router
 * @property \Zemit\Mvc\Url|\Phalcon\Mvc\Url|\Phalcon\Mvc\Url\UrlInterface $url
 * @property \Zemit\Http\Request|\Zemit\Http\RequestInterface|\Phalcon\Http\Request|\Phalcon\Http\RequestInterface $request
 * @property \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface $response
 * @property \Phalcon\Http\Response\Cookies|\Phalcon\Http\Response\CookiesInterface $cookies
 * @property \Zemit\Filter\Filter|\Phalcon\Filter\Filter $filter
 * @property \Phalcon\Flash\Direct $flash
 * @property \Phalcon\Flash\Session $flashSession
 * @property \Phalcon\Session\ManagerInterface $session
 * @property \Phalcon\Events\Manager|\Phalcon\Events\ManagerInterface $eventsManager
 * @property \Phalcon\Db\Adapter\AdapterInterface $db
 * @property \Zemit\Encryption\Security|\Phalcon\Encryption\Security $security
 * @property \Phalcon\Encryption\Crypt|\Phalcon\Encryption\Crypt\CryptInterface $crypt
 * @property \Zemit\Tag|\Phalcon\Tag $tag
 * @property \Zemit\Html\Escaper|\Zemit\Html\Escaper\EscaperInterface|\Phalcon\Html\Escaper|\Phalcon\Html\Escaper\EscaperInterface $escaper
 * @property \Phalcon\Annotations\Adapter\Memory|\Phalcon\Annotations\Adapter $annotations
 * @property \Phalcon\Mvc\Model\Manager|\Phalcon\Mvc\Model\ManagerInterface $modelsManager
 * @property \Phalcon\Mvc\Model\MetaData\Memory|\Phalcon\Mvc\Model\MetadataInterface $modelsMetadata
 * @property \Phalcon\Mvc\Model\Transaction\Manager|\Phalcon\Mvc\Model\Transaction\ManagerInterface $transactionManager
 * @property \Phalcon\Assets\Manager $assets
 * @property \Phalcon\Di\Di|\Phalcon\Di\DiInterface $di
 * @property \Phalcon\Session\Bag|\Phalcon\Session\BagInterface $persistent
 * @property \Phalcon\Mvc\View|\Phalcon\Mvc\ViewInterface $view
 *
 * @property \Zemit\Bootstrap\Config $config
 * @property \Zemit\Bootstrap $bootstrap
 * @property \Zemit\Support\Debug $debug
 * @property \Zemit\Identity\Manager $identity
 * @property \Zemit\Locale $locale
 * @property \Zemit\Support\Utils $utils
 * @property \Zemit\Db\Profiler $profiler
 * @property \Phalcon\Logger\Logger $logger
 * @property \Zemit\Provider\Jwt\Jwt $jwt
 * @property \Zemit\Support\Models $models
 * 
 * @property \Orhanerday\OpenAi\OpenAi $openAi
 * @property joshtronic\LoremIpsum $loremIpsum
 */
trait AbstractInjectable
{
    abstract public function setDI(DiInterface $di): void;
    
    abstract public function getDI(): DiInterface;
}
