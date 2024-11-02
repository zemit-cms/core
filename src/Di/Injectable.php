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

/**
 * This class allows to access services in the services container by just only
 * accessing a public property with the same name of a registered service
 *
 * @property \Phalcon\Mvc\Dispatcher|\Phalcon\Mvc\DispatcherInterface $dispatcher
 * @property \Phalcon\Mvc\Router|\Phalcon\Mvc\RouterInterface $router
 * @property \Phalcon\Mvc\Url|\Phalcon\Mvc\Url\UrlInterface $url
 * @property \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface $response
 * @property \Phalcon\Http\Response\Cookies|\Phalcon\Http\Response\CookiesInterface $cookies
 * @property \Phalcon\Filter\Filter $filter
 * @property \Phalcon\Flash\Direct $flash
 * @property \Phalcon\Flash\Session $flashSession
 * @property \Phalcon\Session\ManagerInterface $session
 * @property \Phalcon\Events\Manager|\Phalcon\Events\ManagerInterface $eventsManager
 * @property \Phalcon\Db\Adapter\AdapterInterface $db
 * @property \Phalcon\Encryption\Crypt|\Phalcon\Encryption\Crypt\CryptInterface $crypt
 * @property \Phalcon\Html\Escaper|\Phalcon\Html\Escaper\EscaperInterface $escaper
 * @property \Phalcon\Annotations\Adapter\Memory|\Phalcon\Annotations\Adapter\AbstractAdapter $annotations
 * @property \Phalcon\Mvc\Model\Manager|\Phalcon\Mvc\Model\ManagerInterface $modelsManager
 * @property \Phalcon\Mvc\Model\MetaData\Memory|\Phalcon\Mvc\Model\MetadataInterface $modelsMetadata
 * @property \Phalcon\Mvc\Model\Transaction\Manager|\Phalcon\Mvc\Model\Transaction\ManagerInterface $transactionManager
 * @property \Phalcon\Assets\Manager $assets
 * @property \Phalcon\Di\Di|\Phalcon\Di\DiInterface $di
 * @property \Phalcon\Session\Bag|\Phalcon\Session\BagInterface $persistent
 * @property \Phalcon\Mvc\View|\Phalcon\Mvc\ViewInterface $view
 * 
 * @property \Zemit\Identity $identity
 * @property \Zemit\Locale $locale
 * @property \Zemit\Encryption\Security $security
 * @property \Zemit\Tag $tag
 * 
 * @property \Zemit\Acl\Acl|\Zemit\Acl\AclInterface $acl
 * @property \Zemit\Support\HelperFactory $helper
 * @property \Zemit\Bootstrap\Config $config
 * @property \Phalcon\Logger\Logger $logger
 * @property \Zemit\Logger\Loggers $loggers
 * @property \Zemit\Db\Profiler $profiler
 * @property \Zemit\Bootstrap $bootstrap
 * @property \Zemit\Provider\Jwt\Jwt $jwt
 * @property \Zemit\Http\Request|\Zemit\Http\RequestInterface $request
 * @property \Zemit\Support\Models $models
 * 
 * // @todo review Phalcon & Zemit DI
 */
class Injectable extends \Phalcon\Di\Injectable implements \Phalcon\Di\InjectionAwareInterface
{
    use InjectableProperties;
}
