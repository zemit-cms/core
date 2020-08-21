<?php

declare(strict_types=1);

namespace Tests\Unit;

use Phalcon\Di;
use Zemit\Bootstrap;
use Phalcon\Incubator\Test\PHPUnit\UnitTestCase;
use PHPUnit\Framework\IncompleteTestError;

/**
 * Class AbstractUnitTest
 * @package Tests\Unit
 */
abstract class AbstractUnitTest extends UnitTestCase
{
    private bool $loaded = false;
    
    /**
     * @var Bootstrap
     */
    protected $bootstrap;
    
    /**
     * Zemit Setup
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        // Zemit Setup
        defined('VENDOR_PATH') || define('VENDOR_PATH', (getenv('VENDOR_PATH') ? getenv('VENDOR_PATH') : dirname(__DIR__) . '/../vendor'));
        defined('APP_NAMESPACE') || define('APP_NAMESPACE', (getenv('APP_NAMESPACE') ? getenv('APP_NAMESPACE') : 'App'));
        defined('APP_PATH') || define('APP_PATH', (getenv('APP_PATH') ? getenv('APP_PATH') : dirname(__DIR__) . '/../app'));
        $this->bootstrap = new Bootstrap();
        $this->di = $this->bootstrap->di;
        $this->loaded = true;
    }
    
    /**
     * Warn user
     */
    public function __destruct()
    {
        if (!$this->loaded) {
            throw new IncompleteTestError('Please run parent::setUp().');
        }
    }
}
