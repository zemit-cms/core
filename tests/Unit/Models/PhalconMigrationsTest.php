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

namespace Zemit\Tests\Unit\Models;

use Zemit\Models\Abstracts\PhalconMigrationsAbstract;
use Zemit\Models\Abstracts\Interfaces\PhalconMigrationsAbstractInterface;
use Zemit\Models\PhalconMigrations;
use Zemit\Models\Interfaces\PhalconMigrationsInterface;

/**
 * Class PhalconMigrationsTest
 *
 * This class contains unit tests for the User class.
 */
class PhalconMigrationsTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public PhalconMigrationsInterface $phalconMigrations;
    
    protected function setUp(): void
    {
        $this->phalconMigrations = new PhalconMigrations();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(PhalconMigrations::class, $this->phalconMigrations);
        $this->assertInstanceOf(PhalconMigrationsInterface::class, $this->phalconMigrations);
    
        // Abstract
        $this->assertInstanceOf(PhalconMigrationsAbstract::class, $this->phalconMigrations);
        $this->assertInstanceOf(PhalconMigrationsAbstractInterface::class, $this->phalconMigrations);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->phalconMigrations);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->phalconMigrations);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->phalconMigrations);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->phalconMigrations);
    }
    
    public function testGetVersion(): void
    {
        $this->assertEquals(null, $this->phalconMigrations->getVersion());
    }
    
    public function testSetVersion(): void
    {
        $value = uniqid();
        $this->phalconMigrations->setVersion($value);
        $this->assertEquals($value, $this->phalconMigrations->getVersion());
    }

    public function testGetStartTime(): void
    {
        $this->assertEquals(null, $this->phalconMigrations->getStartTime());
    }
    
    public function testSetStartTime(): void
    {
        $value = uniqid();
        $this->phalconMigrations->setStartTime($value);
        $this->assertEquals($value, $this->phalconMigrations->getStartTime());
    }

    public function testGetEndTime(): void
    {
        $this->assertEquals(null, $this->phalconMigrations->getEndTime());
    }
    
    public function testSetEndTime(): void
    {
        $value = uniqid();
        $this->phalconMigrations->setEndTime($value);
        $this->assertEquals($value, $this->phalconMigrations->getEndTime());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->phalconMigrations->getColumnMap());
    }
}
