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
use Phalcon\Events\EventInterface;
use Zemit\Di\Injectable;

/**
 * Database Events Security
 * @todo
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
