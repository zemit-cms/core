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

namespace Zemit\Di;

/**
 * @property \Zemit\Acl\AclInterface|\Zemit\Acl\Acl $acl
 * @property \Zemit\Assets\Manager $assets
 * @property \Zemit\Bootstrap $bootstrap
 * @property \Zemit\Bootstrap\Config $config
 * @property \Zemit\Cache\Cache $cache
 * @property \Zemit\Cli\Console $console
 * @property \Zemit\Support\Debug $debug
 * @property \Zemit\Dispatcher\AbstractDispatcher $dispatcher
 * @property \Zemit\Support\Env $env
 * @property \Zemit\Html\Escaper $escaper
 * @property \Zemit\Filter\Filter $filter
 * @property \Zemit\Support\HelperFactory $helper
 * @property \Zemit\Identity\Manager $identity
 * @property \Zemit\Locale $locale
 * @property \Zemit\Logger\Loggers $loggers
 * @property \Zemit\Support\Models $models
 * @property \Zemit\Mvc\Application $application
 * @property \Zemit\Mvc\Model\ManagerInterface $modelsManager
 * @property \Zemit\Db\Profiler $profiler
 * @property \Zemit\Http\RequestInterface $request
 * @property \Zemit\Http\ResponseInterface $response
 * @property \Zemit\Mvc\Router $router
 * @property \Zemit\Encryption\Security $security
 * @property \Zemit\Tag $tag
 * @property \Zemit\Support\Utils $utils
 * @property \Zemit\Support\Version $version
 * @property \Zemit\Mvc\Url $url
 * @property \Zemit\Mvc\View $view
 * @property \Zemit\Provider\Jwt\Jwt $jwt
 *
 * @property \Phalcon\Annotations\Adapter\AdapterInterface $annotations
 * @property \Phalcon\Http\Response\Cookies $cookies
 * @property \Phalcon\Encryption\Crypt $crypt
 * @property \Phalcon\Db\Adapter\AbstractAdapter $db
 * @property \Phalcon\Db\Adapter\AbstractAdapter $dbd
 * @property \Phalcon\Db\Adapter\AbstractAdapter $dbr
 * @property \Phalcon\Events\ManagerInterface $eventsManager
 * @property \Phalcon\Flash\FlashInterface $flash
 * @property \Phalcon\Logger\LoggerInterface $logger
 * @property \Phalcon\Incubator\Mailer\Manager $mailer
 * @property \Phalcon\Cache\CacheInterface $modelsCache
 * @property \Phalcon\Mvc\Model\MetaDataInterface $modelsMetadata
 * @property \Phalcon\Session\ManagerInterface $session
 * @property \Phalcon\Translate\Adapter\AdapterInterface $translate
 * @property \Phalcon\Mvc\View\Engine\Volt $volt
 * @property \Phalcon\Di\FactoryDefault|\Phalcon\Di\Di|\Phalcon\Di\DiInterface $di
 *
 * @property \Aws\Sdk $aws
 * @property \League\Flysystem\Filesystem $fileSystem
 * @property \League\OAuth2\Client\Provider\GenericProvider $oauth2Client
 * @property \League\OAuth2\Client\Provider\Facebook $oauth2Facebook
 * @property \League\OAuth2\Client\Provider\Google $oauth2Google
 * @property \joshtronic\LoremIpsum $loremIpsum
 * @property \Orhanerday\OpenAi\OpenAi $openAi
 * @property \PhpImap\Mailbox $imap
 * @property \ReCaptcha\ReCaptcha $reCaptcha
 * @property \thiagoalessio\TesseractOCR\TesseractOCR $ocr
 * @property \Xenolope\Quahog\Client $clamav
 */
trait InjectableProperties
{
}
