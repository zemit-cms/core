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
 * @todo add missing
 * @todo make interface for everything
 * @todo make wrapper for externals
 * @todo make wrapper for phalcon
 *
 * @property \Phalcon\Di\FactoryDefault|\Phalcon\Di\Di|\Phalcon\Di\DiInterface $di
 * @property \Zemit\Bootstrap $bootstrap
 * @property \Zemit\Acl\AclInterface|\Zemit\Acl\Acl $acl
 * @property \Zemit\Mvc\Application $application
 * @property \Zemit\Assets\Manager $assets
 * @property \Phalcon\Annotations\Adapter\AdapterInterface $annotations
 * @property \Aws\Sdk $aws
 * @property \Zemit\Cache\Cache $cache
 * @property \Xenolope\Quahog\Client $clamav
 * @property \Zemit\Bootstrap\Config $config
 * @property \Zemit\Cli\Console $console
 * @property \Phalcon\Http\Response\Cookies $cookies
 * @property \Phalcon\Encryption\Crypt $crypt
 * @property \Phalcon\Db\Adapter\AbstractAdapter $db
 * @property \Phalcon\Db\Adapter\AbstractAdapter $dbr
 * @property \Phalcon\Db\Adapter\AbstractAdapter $dbd
 * @property \Zemit\Support\Debug $debug
 * @property \Zemit\Dispatcher\AbstractDispatcher $dispatcher
 * @property \Zemit\Support\Env $env
 * @property \Zemit\Html\Escaper $escaper
 * @property \Phalcon\Events\ManagerInterface $eventsManager
 * @property \League\Flysystem\Filesystem $fileSystem
 * @property \Zemit\Filter\Filter $filter
 * @property \Phalcon\Flash\FlashInterface $flash
// * @property \Zemit\Support\Gravatar $gravatar
 * @property \Zemit\Support\Helper $helper
 * @property \Zemit\Identity\Manager $identity
 * @property \PhpImap\Mailbox $imap
 * @property \Zemit\Provider\Jwt\Jwt $jwt
 * @property \Zemit\Locale $locale
 * @property \Zemit\Logger\Loggers $loggers
 * @property \Phalcon\Logger\LoggerInterface $logger
 * @property \joshtronic\LoremIpsum $loremIpsum
 * @property \Phalcon\Incubator\Mailer\Manager $mailer
 * @property \Zemit\Support\Models $models
 * @property \Phalcon\Cache\CacheInterface $modelsCache
 * @property \Zemit\Mvc\Model\ManagerInterface $modelsManager
 * @property \Phalcon\Mvc\Model\MetaDataInterface $modelsMetadata
 * @property \League\OAuth2\Client\Provider\GenericProvider $oauth2Client
 * @property \League\OAuth2\Client\Provider\Facebook $oauth2Facebook
 * @property \League\OAuth2\Client\Provider\Google $oauth2Google
 * @property \thiagoalessio\TesseractOCR\TesseractOCR $ocr
 * @property \Orhanerday\OpenAi\OpenAi $openAi
 * @property \Zemit\Db\Profiler $profiler
 * @property \ReCaptcha\ReCaptcha $reCaptcha
 * @property \Zemit\Http\RequestInterface $request
 * @property \Phalcon\Http\ResponseInterface $response
 * @property \Zemit\Mvc\Router $router
 * @property \Zemit\Encryption\Security $security
 * @property \Phalcon\Session\ManagerInterface $session
 * @property \Zemit\Tag $tag
 * @property \Phalcon\Translate\Adapter\AdapterInterface $translate
 * @property \Zemit\Mvc\Url $url
 * @property \Zemit\Support\Utils $utils
 * @property \Zemit\Support\Version $version
 * @property \Zemit\Mvc\View $view
 * @property \Phalcon\Mvc\View\Engine\Volt $volt
 */
trait InjectableProperties
{
}
