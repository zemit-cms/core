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

use Phalcon\Logger;
use Zemit\Bootstrap;
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

/**
 * Class Injectable
 * {@inheritDoc}
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @property Bootstrap\Config $config
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
 *
 * @package Zemit\Di
 */
class Injectable extends \Phalcon\Di\Injectable implements \Phalcon\Di\InjectionAwareInterface
{

}
