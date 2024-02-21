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

use Phalcon\Db\Adapter\Pdo\Mysql;
use PHPUnit\Framework\TestCase;
use Phalcon\Di\DiInterface;
use Zemit\Bootstrap;
use Zemit\Bootstrap\Config;
use Zemit\Exception;
use Zemit\Utils\Env;
use Phalcon\Autoload\Loader;

/**
 * Class AbstractUnitTest
 * @package Tests\Unit
 * @coversNothing
 */
abstract class AbstractUnit extends TestCase
{
    protected bool $loaded = false;
    
    protected ?Bootstrap $bootstrap = null;
    
    protected ?DiInterface $di = null;
    
    protected ?Loader $loader = null;
    
    protected string $mode = Bootstrap::MODE_MVC;
    
    public function getDb(): Mysql
    {
        return $this->di->get('db');
    }
    
    public function getConfig(): Config
    {
        return $this->di->get('config');
    }
    
    /**
     * Zemit Setup
     * @throws Exception
     */
    protected function setUp(): void
    {
        // Set your default path and namespace
        defined('VENDOR_PATH') || define('VENDOR_PATH', (getenv('VENDOR_PATH') ? getenv('VENDOR_PATH') : dirname(__DIR__) . '/../vendor'));
        defined('APP_NAMESPACE') || define('APP_NAMESPACE', (getenv('APP_NAMESPACE') ? getenv('APP_NAMESPACE') : 'App'));
        defined('APP_PATH') || define('APP_PATH', (getenv('APP_PATH') ? getenv('APP_PATH') : dirname(__DIR__) . '/../app'));
        
        Env::setNames(['.env.testing']);
        
        $this->loader = new Loader();
        $this->loader->setFiles([VENDOR_PATH . 'autoload.php']);
        $this->loader->setNamespaces(['Zemit' => APP_PATH]);
        $this->loader->register();
        
        $this->bootstrap = new Bootstrap($this->mode);
        $this->di = $this->bootstrap->di;
        $this->loaded = true;
        parent::setUp();
    }
    
    protected function tearDown(): void
    {
        $this->loader = null;
        $this->bootstrap = null;
        $this->di = null;
        $this->loaded = false;
        parent::tearDown();
    }
}
