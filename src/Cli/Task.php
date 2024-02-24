<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Cli;

use joshtronic\LoremIpsum;
use Orhanerday\OpenAi\OpenAi;
use Phalcon\Logger\Logger;
use Zemit\Bootstrap;
use Zemit\Db\Profiler;
use Zemit\Html\Escaper;
use Zemit\Support\Debug;
use Zemit\Encryption\Security;
use Zemit\Filter\Filter;
use Zemit\Identity;
use Zemit\Locale;
use Zemit\Mvc\View;
use Zemit\Provider\Jwt\Jwt;
use Zemit\Support\Utils;

/**
 * @property Bootstrap\Config $config
 * @property Bootstrap $bootstrap
 * @property Debug $debug
 * @property Router $router
 * @property Dispatcher $dispatcher
 * @property View $view
 * @property Security $security
 * @property Profiler $profiler
 * @property Jwt $jwt
 * @property Escaper $escaper
 * @property Filter $filter
 * @property Identity $identity
 * @property Locale $locale
 * @property Logger $logger
 * @property Utils $utils
 * @property LoremIpsum $loremIpsum
 * @property OpenAi $openAi
 */
class Task extends \Phalcon\Cli\Task implements TaskInterface
{

}
