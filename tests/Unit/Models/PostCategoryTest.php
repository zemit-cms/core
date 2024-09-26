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

use Zemit\Models\Abstracts\PostCategoryAbstract;
use Zemit\Models\Abstracts\Interfaces\PostCategoryAbstractInterface;
use Zemit\Models\PostCategory;
use Zemit\Models\Interfaces\PostCategoryInterface;

/**
 * Class PostCategoryTest
 *
 * This class contains unit tests for the User class.
 */
class PostCategoryTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public PostCategoryInterface $postCategory;
    
    protected function setUp(): void
    {
        $this->postCategory = new PostCategory();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(PostCategory::class, $this->postCategory);
        $this->assertInstanceOf(PostCategoryInterface::class, $this->postCategory);
    
        // Abstract
        $this->assertInstanceOf(PostCategoryAbstract::class, $this->postCategory);
        $this->assertInstanceOf(PostCategoryAbstractInterface::class, $this->postCategory);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->postCategory);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->postCategory);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->postCategory);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->postCategory);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->postCategory->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->postCategory->setId($value);
        $this->assertEquals($value, $this->postCategory->getId());
    }

    public function testGetPostId(): void
    {
        $this->assertEquals(null, $this->postCategory->getPostId());
    }
    
    public function testSetPostId(): void
    {
        $value = uniqid();
        $this->postCategory->setPostId($value);
        $this->assertEquals($value, $this->postCategory->getPostId());
    }

    public function testGetCategoryId(): void
    {
        $this->assertEquals(null, $this->postCategory->getCategoryId());
    }
    
    public function testSetCategoryId(): void
    {
        $value = uniqid();
        $this->postCategory->setCategoryId($value);
        $this->assertEquals($value, $this->postCategory->getCategoryId());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->postCategory->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->postCategory->setDeleted($value);
        $this->assertEquals($value, $this->postCategory->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->postCategory->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->postCategory->setCreatedAt($value);
        $this->assertEquals($value, $this->postCategory->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->postCategory->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->postCategory->setCreatedBy($value);
        $this->assertEquals($value, $this->postCategory->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->postCategory->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->postCategory->setCreatedAs($value);
        $this->assertEquals($value, $this->postCategory->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->postCategory->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->postCategory->setUpdatedAt($value);
        $this->assertEquals($value, $this->postCategory->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->postCategory->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->postCategory->setUpdatedBy($value);
        $this->assertEquals($value, $this->postCategory->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->postCategory->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->postCategory->setUpdatedAs($value);
        $this->assertEquals($value, $this->postCategory->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->postCategory->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->postCategory->setDeletedAt($value);
        $this->assertEquals($value, $this->postCategory->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->postCategory->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->postCategory->setDeletedAs($value);
        $this->assertEquals($value, $this->postCategory->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->postCategory->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->postCategory->setDeletedBy($value);
        $this->assertEquals($value, $this->postCategory->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->postCategory->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->postCategory->setRestoredAt($value);
        $this->assertEquals($value, $this->postCategory->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->postCategory->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->postCategory->setRestoredBy($value);
        $this->assertEquals($value, $this->postCategory->getRestoredBy());
    }

    public function testGetDeletedCopy1(): void
    {
        $this->assertEquals(null, $this->postCategory->getDeletedCopy1());
    }
    
    public function testSetDeletedCopy1(): void
    {
        $value = uniqid();
        $this->postCategory->setDeletedCopy1($value);
        $this->assertEquals($value, $this->postCategory->getDeletedCopy1());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->postCategory->getColumnMap());
    }
}
