<?php

use Codeception\Test\Unit;

use Phalcon\DiInterface;
use Phalcon\DispatcherInterface;

class HelpersTest extends Unit
{
    /**
     * UnitTester Object
     * @var \UnitTester
     */
    protected $tester;

    protected $appPath;
    protected $cachePath;
    protected $configPath;

    public function _before()
    {
        parent::_before();

        $this->appPath = dirname(dirname(__DIR__)) . '/app';
        $this->cachePath = dirname(dirname(__DIR__)) . '/storage/cache';
        $this->configPath = dirname(dirname(__DIR__)) . '/config';
    }

    public function testAppPath()
    {
        $this->assertEquals($this->appPath, APP_PATH);
    }
}
