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
use Zemit\Identity;
use Zemit\Tag;
use Zemit\Utils;

/**
 * Class Controller
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
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
 * @property \Zemit\Cache\Cache $cache
 */
class Controller extends \Phalcon\Mvc\Controller
{

}
