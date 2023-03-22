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

use Zemit\Bootstrap;
use Zemit\Cli\Router as CliRouter;
use Zemit\MVc\Router as MvcRouter;
use Zemit\Db\Profiler;
use Zemit\Debug;
use Zemit\Escaper;
use Zemit\Filter;
use Zemit\Http\Request;
use Zemit\Identity;
use Zemit\Locale;
use Zemit\Mvc\Dispatcher;
use Zemit\Provider\Jwt\Jwt;
use Zemit\Security;
use Zemit\Tag;
use Zemit\Utils;
use Phalcon\Logger;
use joshtronic\LoremIpsum;
use Orhanerday\OpenAi\OpenAi;

/**
 * {@inheritDoc}
 *
 * @property Bootstrap\Config $config
 * @property CliRouter|MvcRouter $router
 * @property Bootstrap $bootstrap
 * @property Debug $debug
 * @property Escaper $escaper
 * @property Filter $filter
 * @property Request $request
 * @property Identity $identity
 * @property Locale $locale
 * @property Dispatcher $dispatcher
 * @property Security $security
 * @property Tag $tag
 * @property Utils $utils
 * @property Profiler $profiler
 * @property Logger $logger
 * @property Jwt $jwt
 * @property OpenAi $openAi
 * @property LoremIpsum $loremIpsum
 */
class Injectable extends \Phalcon\Di\Injectable implements \Phalcon\Di\InjectionAwareInterface
{
}
