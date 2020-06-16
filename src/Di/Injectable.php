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
use Zemit\Bootstrap\Config;
use Zemit\Escaper;
use Zemit\Filter;
use Zemit\Identity;
use Zemit\Tag;

/**
 * Class Injectable
 * This class allows to access services in the services container by just only
 * accessing a public property with the same name of a registered service
 *
 * @property Bootstrap $bootstrap
 * @property Config $config
 * @property Identity $identity
 * @property Tag $tag
 * @property Escaper $escaper
 * @property Filter $filter
 *
 * @package Zemit\Di
 */
class Injectable extends \Phalcon\Di\Injectable implements \Phalcon\Di\InjectionAwareInterface
{
    
}
