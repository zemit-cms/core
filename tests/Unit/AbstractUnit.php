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

use Phalcon\Autoload\Loader;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Di\DiInterface;
use PHPUnit\Framework\TestCase;
use Zemit\Bootstrap;
use Zemit\Bootstrap\Config;
use Zemit\Exception;
use Zemit\Support\Env;

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
        $rootDir = dirname(dirname(__DIR__)) . '/';
        Env::setNames(['.env.testing']);
        Env::load();
        
        $loader = new Loader();
        $loader->setFiles([$rootDir . '/vendor/autoload.php']);
        $loader->setNamespaces(['Zemit' => $rootDir . '/src']);
        $loader->setFileCheckingCallback(null);
        $loader->register();
        
        $this->bootstrap = new Bootstrap($this->mode);
        $this->di = $this->bootstrap->di;
        $this->loader = $loader;
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
