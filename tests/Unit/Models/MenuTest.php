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

    public function testGetName(): void
    {
        $this->assertEquals(null, $this->menu->getName());
    }
    
    public function testSetName(): void
    {
        $value = uniqid();
        $this->menu->setName($value);
        $this->assertEquals($value, $this->menu->getName());
    }

    public function testGetIndex(): void
    {
        $this->assertEquals(null, $this->menu->getIndex());
    }
    
    public function testSetIndex(): void
    {
        $value = uniqid();
        $this->menu->setIndex($value);
        $this->assertEquals($value, $this->menu->getIndex());
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
        $this->assertEquals(null, $this->menu->getCreatedAt());
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

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->menu->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->menu->setCreatedAs($value);
        $this->assertEquals($value, $this->menu->getCreatedAs());
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

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->menu->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->menu->setUpdatedAs($value);
        $this->assertEquals($value, $this->menu->getUpdatedAs());
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

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->menu->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->menu->setDeletedAs($value);
        $this->assertEquals($value, $this->menu->getDeletedAs());
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

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->menu->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->menu->setRestoredAt($value);
        $this->assertEquals($value, $this->menu->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->menu->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->menu->setRestoredBy($value);
        $this->assertEquals($value, $this->menu->getRestoredBy());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->menu->getColumnMap());
    }
}