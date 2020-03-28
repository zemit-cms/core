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

use Phalcon\Di\Injectable;
use Phalcon\Events\EventInterface;
use Phalcon\Db\AdapterInterface;

class Profiler extends Injectable
{
    /**
     * @var \Phalcon\Db\Profiler;
     */
    protected $_profiler;
    
    public function __construct(Phalcon\Db\Profiler $profiler = null) {
        $this->_profiler = $profiler ?? $this->profiler ?? new \Phalcon\Db\Profiler();
    }
    
    public function beforeQuery(EventInterface $event, AdapterInterface $connection) {
        $this->_profiler->startProfile($connection->getSQLStatement());
    }
    
    public function afterQuery(EventInterface $event, AdapterInterface $connection) {
        $this->_profiler->stopProfile();
    }
    
}
