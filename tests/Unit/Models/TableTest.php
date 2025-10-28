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

use Zemit\Models\Abstracts\TableAbstract;
use Zemit\Models\Abstracts\Interfaces\TableAbstractInterface;
use Zemit\Models\Table;
use Zemit\Models\Interfaces\TableInterface;

/**
 * Class TableTest
 *
 * This class contains unit tests for the User class.
 */
class TableTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public TableInterface $table;
    
    protected function setUp(): void
    {
        $this->table = new Table();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(Table::class, $this->table);
        $this->assertInstanceOf(TableInterface::class, $this->table);
    
        // Abstract
        $this->assertInstanceOf(TableAbstract::class, $this->table);
        $this->assertInstanceOf(TableAbstractInterface::class, $this->table);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->table);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->table);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->table);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->table);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->table->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->table->setId($value);
        $this->assertEquals($value, $this->table->getId());
    }

    public function testGetUuid(): void
    {
        $this->assertEquals(null, $this->table->getUuid());
    }
    
    public function testSetUuid(): void
    {
        $value = uniqid();
        $this->table->setUuid($value);
        $this->assertEquals($value, $this->table->getUuid());
    }

    public function testGetWorkspaceId(): void
    {
        $this->assertEquals(null, $this->table->getWorkspaceId());
    }
    
    public function testSetWorkspaceId(): void
    {
        $value = uniqid();
        $this->table->setWorkspaceId($value);
        $this->assertEquals($value, $this->table->getWorkspaceId());
    }

    public function testGetLabel(): void
    {
        $this->assertEquals(null, $this->table->getLabel());
    }
    
    public function testSetLabel(): void
    {
        $value = uniqid();
        $this->table->setLabel($value);
        $this->assertEquals($value, $this->table->getLabel());
    }

    public function testGetDescription(): void
    {
        $this->assertEquals(null, $this->table->getDescription());
    }
    
    public function testSetDescription(): void
    {
        $value = uniqid();
        $this->table->setDescription($value);
        $this->assertEquals($value, $this->table->getDescription());
    }

    public function testGetIcon(): void
    {
        $this->assertEquals(null, $this->table->getIcon());
    }
    
    public function testSetIcon(): void
    {
        $value = uniqid();
        $this->table->setIcon($value);
        $this->assertEquals($value, $this->table->getIcon());
    }

    public function testGetColor(): void
    {
        $this->assertEquals(null, $this->table->getColor());
    }
    
    public function testSetColor(): void
    {
        $value = uniqid();
        $this->table->setColor($value);
        $this->assertEquals($value, $this->table->getColor());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->table->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->table->setDeleted($value);
        $this->assertEquals($value, $this->table->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals('current_timestamp()', $this->table->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->table->setCreatedAt($value);
        $this->assertEquals($value, $this->table->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->table->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->table->setCreatedBy($value);
        $this->assertEquals($value, $this->table->getCreatedBy());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->table->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->table->setUpdatedAt($value);
        $this->assertEquals($value, $this->table->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->table->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->table->setUpdatedBy($value);
        $this->assertEquals($value, $this->table->getUpdatedBy());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->table->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->table->setDeletedAt($value);
        $this->assertEquals($value, $this->table->getDeletedAt());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->table->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->table->setDeletedBy($value);
        $this->assertEquals($value, $this->table->getDeletedBy());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->table->getColumnMap());
    }
}
