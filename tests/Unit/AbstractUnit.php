<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Zemit\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Phalcon\Di\DiInterface;
use Zemit\Bootstrap;
use Zemit\Utils\Env;

/**
 * Class AbstractUnitTest
 * @package Tests\Unit
 */
abstract class AbstractUnit extends TestCase
{
    protected bool $loaded = false;
    
    protected ?Bootstrap $bootstrap;
    
    protected ?DiInterface $di;
    
    protected string $mode = Bootstrap::MODE_MVC;
    
    /**
     * Zemit Setup
     */
    protected function setUp(): void
    {
        // Zemit Setup
        defined('VENDOR_PATH') || define('VENDOR_PATH', (getenv('VENDOR_PATH') ? getenv('VENDOR_PATH') : dirname(__DIR__) . '/../vendor'));
        defined('APP_NAMESPACE') || define('APP_NAMESPACE', (getenv('APP_NAMESPACE') ? getenv('APP_NAMESPACE') : 'App'));
        defined('APP_PATH') || define('APP_PATH', (getenv('APP_PATH') ? getenv('APP_PATH') : dirname(__DIR__) . '/../app'));
        
        Env::setNames(['.env.testing']);
        
        $this->bootstrap = new Bootstrap($this->mode);
        $this->di = $this->bootstrap->di;
        $this->loaded = true;
        parent::setUp();
    }
    
    protected function tearDown(): void
    {
        $this->bootstrap = null;
        $this->di = null;
        parent::tearDown();
    }
}
