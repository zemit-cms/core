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
use Zemit\Db\Profiler;
use Zemit\Escaper;
use Zemit\Filter;
use Zemit\Http\Request;
use Zemit\Identity;
use Zemit\Tag;
use Zemit\Utils;
use Zemit\Cache;

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
 */
class Controller extends \Phalcon\Mvc\Controller
{
}
