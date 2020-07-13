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
use Zemit\Escaper;
use Zemit\Filter;
use Zemit\Identity;
use Zemit\Tag;
use Zemit\Utils;
use Xenolope\Quahog\Client as Clamav;

/**
 * @author Julien Turbide <jturbide@nuagerie.com>
 *
 * @property Application $application
 * @property Bootstrap $bootstrap
 * @property Utils $utils
 * @property Identity $identity
 * @property Config $config
 * @property Clamav $clamav
 * @property Tag $tag
 * @property Escaper $escaper
 * @property Filter $filter
 * @property Dispatcher $dispatcher
 * @property Router $router
 */
class Controller extends \Phalcon\Mvc\Controller
{

}
