<?php

namespace Zemit\Db;

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
        $this->_profiler = isset($profiler)? $profiler : $this->getDI()->getShared('profiler');
    }
    
    public function beforeQuery(EventInterface $event, AdapterInterface $connection) {
        $this->_profiler->startProfile($connection->getSQLStatement());
    }
    
    public function afterQuery(EventInterface $event, AdapterInterface $connection) {
        $this->_profiler->stopProfile();
    }
    
}
