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
use Phalcon\Logger;
use Zemit\Bootstrap;
use Zemit\Db\Profiler;
use Zemit\Debug;
use Zemit\Escaper;
use Zemit\Filter;
use Zemit\Identity;
use Zemit\Locale;
use Zemit\Provider\Jwt\Jwt;
use Zemit\Security;
use Zemit\Utils;

/**
 * @property Bootstrap\Config $config
 * @property Router $router
 * @property Bootstrap $bootstrap
 * @property Debug $debug
 * @property Escaper $escaper
 * @property Filter $filter
 * @property Identity $identity
 * @property Locale $locale
 * @property Dispatcher $dispatcher
 * @property Security $security
 * @property Utils $utils
 * @property Profiler $profiler
 * @property Logger $logger
 * @property Jwt $jwt
 * @property OpenAi $openAi
 * @property LoremIpsum $loremIpsum
 */
class Task extends \Phalcon\Cli\Task implements TaskInterface
{

}
