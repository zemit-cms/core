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

use Zemit\Models\Abstracts\CategoryAbstract;
use Zemit\Models\Abstracts\Interfaces\CategoryAbstractInterface;
use Zemit\Models\Category;
use Zemit\Models\Interfaces\CategoryInterface;

/**
 * Class CategoryTest
 *
 * This class contains unit tests for the User class.
 */
class CategoryTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public CategoryInterface $category;
    
    protected function setUp(): void
    {
        $this->category = new Category();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(Category::class, $this->category);
        $this->assertInstanceOf(CategoryInterface::class, $this->category);
    
        // Abstract
        $this->assertInstanceOf(CategoryAbstract::class, $this->category);
        $this->assertInstanceOf(CategoryAbstractInterface::class, $this->category);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->category);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->category);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->category);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->category);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->category->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->category->setId($value);
        $this->assertEquals($value, $this->category->getId());
    }

    public function testGetSiteId(): void
    {
        $this->assertEquals(null, $this->category->getSiteId());
    }
    
    public function testSetSiteId(): void
    {
        $value = uniqid();
        $this->category->setSiteId($value);
        $this->assertEquals($value, $this->category->getSiteId());
    }

    public function testGetLangId(): void
    {
        $this->assertEquals(null, $this->category->getLangId());
    }
    
    public function testSetLangId(): void
    {
        $value = uniqid();
        $this->category->setLangId($value);
        $this->assertEquals($value, $this->category->getLangId());
    }

    public function testGetName(): void
    {
        $this->assertEquals(null, $this->category->getName());
    }
    
    public function testSetName(): void
    {
        $value = uniqid();
        $this->category->setName($value);
        $this->assertEquals($value, $this->category->getName());
    }

    public function testGetIndex(): void
    {
        $this->assertEquals(null, $this->category->getIndex());
    }
    
    public function testSetIndex(): void
    {
        $value = uniqid();
        $this->category->setIndex($value);
        $this->assertEquals($value, $this->category->getIndex());
    }

    public function testGetDescription(): void
    {
        $this->assertEquals(null, $this->category->getDescription());
    }
    
    public function testSetDescription(): void
    {
        $value = uniqid();
        $this->category->setDescription($value);
        $this->assertEquals($value, $this->category->getDescription());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->category->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->category->setDeleted($value);
        $this->assertEquals($value, $this->category->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->category->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->category->setCreatedAt($value);
        $this->assertEquals($value, $this->category->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->category->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->category->setCreatedBy($value);
        $this->assertEquals($value, $this->category->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->category->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->category->setCreatedAs($value);
        $this->assertEquals($value, $this->category->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->category->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->category->setUpdatedAt($value);
        $this->assertEquals($value, $this->category->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->category->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->category->setUpdatedBy($value);
        $this->assertEquals($value, $this->category->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->category->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->category->setUpdatedAs($value);
        $this->assertEquals($value, $this->category->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->category->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->category->setDeletedAt($value);
        $this->assertEquals($value, $this->category->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->category->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->category->setDeletedAs($value);
        $this->assertEquals($value, $this->category->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->category->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->category->setDeletedBy($value);
        $this->assertEquals($value, $this->category->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->category->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->category->setRestoredAt($value);
        $this->assertEquals($value, $this->category->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->category->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->category->setRestoredBy($value);
        $this->assertEquals($value, $this->category->getRestoredBy());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->category->getColumnMap());
    }
}