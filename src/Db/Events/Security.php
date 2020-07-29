<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Db\Events;

use Phalcon\Db\Adapter\AbstractAdapter;
use Zemit\Di\Injectable;
use Phalcon\Events\EventInterface;

/**
 * Class Security
 * Database Events Security
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Db\Events
 */
class Security extends Injectable
{
    public function beforeQuery(EventInterface $event, AbstractAdapter $connection)
    {
//        $model = '';
//        $acl = $this->security->getAcl('controllers');
//        $event->stop();
    }
}
