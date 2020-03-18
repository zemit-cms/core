<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Modules\Cli\Tasks;

use Zemit\Mail\SendSpool;
use Zemit\Console\AbstractTask;

/**
 * Zemit\Modules\Cli\Tasks\Notifications
 *
 * @package Zemit\Modules\Cli\Tasks
 */
class NotificationsTask extends AbstractTask
{
    /**
     * @Doc("Check notifications marked as not send on the databases and send them")
     */
    public function send()
    {
        $spool = new SendSpool();
        $spool->sendRemaining();
    }

    /**
     * @Doc("Check the queue and send the notifications scheduled there")
     */
    public function queue()
    {
        $spool = new SendSpool();
        $spool->consumeQueue();
    }
}
