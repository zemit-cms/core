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

use Zemit\Models\Abstracts\PostAbstract;
use Zemit\Models\Abstracts\Interfaces\PostAbstractInterface;
use Zemit\Models\Post;
use Zemit\Models\Interfaces\PostInterface;

/**
 * Class PostTest
 *
 * This class contains unit tests for the User class.
 */
class PostTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public PostInterface $post;
    
    protected function setUp(): void
    {
        $this->post = new Post();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(Post::class, $this->post);
        $this->assertInstanceOf(PostInterface::class, $this->post);
    
        // Abstract
        $this->assertInstanceOf(PostAbstract::class, $this->post);
        $this->assertInstanceOf(PostAbstractInterface::class, $this->post);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->post);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->post);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->post);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->post);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->post->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->post->setId($value);
        $this->assertEquals($value, $this->post->getId());
    }

    public function testGetLangId(): void
    {
        $this->assertEquals(null, $this->post->getLangId());
    }
    
    public function testSetLangId(): void
    {
        $value = uniqid();
        $this->post->setLangId($value);
        $this->assertEquals($value, $this->post->getLangId());
    }

    public function testGetSiteId(): void
    {
        $this->assertEquals(null, $this->post->getSiteId());
    }
    
    public function testSetSiteId(): void
    {
        $value = uniqid();
        $this->post->setSiteId($value);
        $this->assertEquals($value, $this->post->getSiteId());
    }

    public function testGetPageId(): void
    {
        $this->assertEquals(null, $this->post->getPageId());
    }
    
    public function testSetPageId(): void
    {
        $value = uniqid();
        $this->post->setPageId($value);
        $this->assertEquals($value, $this->post->getPageId());
    }

    public function testGetName(): void
    {
        $this->assertEquals(null, $this->post->getName());
    }
    
    public function testSetName(): void
    {
        $value = uniqid();
        $this->post->setName($value);
        $this->assertEquals($value, $this->post->getName());
    }

    public function testGetDescription(): void
    {
        $this->assertEquals(null, $this->post->getDescription());
    }
    
    public function testSetDescription(): void
    {
        $value = uniqid();
        $this->post->setDescription($value);
        $this->assertEquals($value, $this->post->getDescription());
    }

    public function testGetContent(): void
    {
        $this->assertEquals(null, $this->post->getContent());
    }
    
    public function testSetContent(): void
    {
        $value = uniqid();
        $this->post->setContent($value);
        $this->assertEquals($value, $this->post->getContent());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->post->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->post->setDeleted($value);
        $this->assertEquals($value, $this->post->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->post->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->post->setCreatedAt($value);
        $this->assertEquals($value, $this->post->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->post->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->post->setCreatedBy($value);
        $this->assertEquals($value, $this->post->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->post->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->post->setCreatedAs($value);
        $this->assertEquals($value, $this->post->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->post->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->post->setUpdatedAt($value);
        $this->assertEquals($value, $this->post->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->post->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->post->setUpdatedBy($value);
        $this->assertEquals($value, $this->post->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->post->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->post->setUpdatedAs($value);
        $this->assertEquals($value, $this->post->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->post->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->post->setDeletedAt($value);
        $this->assertEquals($value, $this->post->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->post->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->post->setDeletedAs($value);
        $this->assertEquals($value, $this->post->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->post->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->post->setDeletedBy($value);
        $this->assertEquals($value, $this->post->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->post->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->post->setRestoredAt($value);
        $this->assertEquals($value, $this->post->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->post->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->post->setRestoredBy($value);
        $this->assertEquals($value, $this->post->getRestoredBy());
    }

    public function testGetRestoredAs(): void
    {
        $this->assertEquals(null, $this->post->getRestoredAs());
    }
    
    public function testSetRestoredAs(): void
    {
        $value = uniqid();
        $this->post->setRestoredAs($value);
        $this->assertEquals($value, $this->post->getRestoredAs());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->post->getColumnMap());
    }
}
