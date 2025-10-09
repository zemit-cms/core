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

use Zemit\Models\Abstracts\MenuAbstract;
use Zemit\Models\Abstracts\Interfaces\MenuAbstractInterface;
use Zemit\Models\Menu;
use Zemit\Models\Interfaces\MenuInterface;

/**
 * Class MenuTest
 *
 * This class contains unit tests for the User class.
 */
class MenuTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public MenuInterface $menu;
    
    protected function setUp(): void
    {
        $this->menu = new Menu();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(Menu::class, $this->menu);
        $this->assertInstanceOf(MenuInterface::class, $this->menu);
    
        // Abstract
        $this->assertInstanceOf(MenuAbstract::class, $this->menu);
        $this->assertInstanceOf(MenuAbstractInterface::class, $this->menu);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->menu);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->menu);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->menu);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->menu);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->menu->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->menu->setId($value);
        $this->assertEquals($value, $this->menu->getId());
    }

    public function testGetUuid(): void
    {
        $this->assertEquals(null, $this->menu->getUuid());
    }
    
    public function testSetUuid(): void
    {
        $value = uniqid();
        $this->menu->setUuid($value);
        $this->assertEquals($value, $this->menu->getUuid());
    }

    public function testGetParentId(): void
    {
        $this->assertEquals(null, $this->menu->getParentId());
    }
    
    public function testSetParentId(): void
    {
        $value = uniqid();
        $this->menu->setParentId($value);
        $this->assertEquals($value, $this->menu->getParentId());
    }

    public function testGetKey(): void
    {
        $this->assertEquals(null, $this->menu->getKey());
    }
    
    public function testSetKey(): void
    {
        $value = uniqid();
        $this->menu->setKey($value);
        $this->assertEquals($value, $this->menu->getKey());
    }

    public function testGetLabel(): void
    {
        $this->assertEquals(null, $this->menu->getLabel());
    }
    
    public function testSetLabel(): void
    {
        $value = uniqid();
        $this->menu->setLabel($value);
        $this->assertEquals($value, $this->menu->getLabel());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->menu->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->menu->setDeleted($value);
        $this->assertEquals($value, $this->menu->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals('current_timestamp()', $this->menu->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->menu->setCreatedAt($value);
        $this->assertEquals($value, $this->menu->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->menu->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->menu->setCreatedBy($value);
        $this->assertEquals($value, $this->menu->getCreatedBy());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->menu->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->menu->setUpdatedAt($value);
        $this->assertEquals($value, $this->menu->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->menu->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->menu->setUpdatedBy($value);
        $this->assertEquals($value, $this->menu->getUpdatedBy());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->menu->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->menu->setDeletedAt($value);
        $this->assertEquals($value, $this->menu->getDeletedAt());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->menu->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->menu->setDeletedBy($value);
        $this->assertEquals($value, $this->menu->getDeletedBy());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->menu->getColumnMap());
    }
}
