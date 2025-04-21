<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc;

use Zemit\Bootstrap;
use Zemit\Bootstrap\Config;
use Zemit\Cache\Cache;
use Zemit\Db\Profiler;
use Zemit\Filter\Filter;
use Zemit\Html\Escaper;
use Zemit\Http\Request;
use Zemit\Identity\Manager as Identity;
use Zemit\Provider\Jwt\Jwt;
use Zemit\Support\Utils;
use Zemit\Tag;

/**
 * Class Controller
 *
 * @property Application $application
 * @property Bootstrap $bootstrap
 * @property Utils $utils
 * @property Profiler $profiler
 * @property Identity $identity
 * @property Config $config
 * @property Tag $tag
 * @property Escaper $escaper
 * @property Filter $filter
 * @property Dispatcher $dispatcher
 * @property Router $router
 * @property Cache $cache
 * @property Request $request
 * @property Jwt $jwt
 */
class Controller extends \Phalcon\Mvc\Controller
{
}
