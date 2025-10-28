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

    public function testGetUuid(): void
    {
        $this->assertEquals(null, $this->post->getUuid());
    }
    
    public function testSetUuid(): void
    {
        $value = uniqid();
        $this->post->setUuid($value);
        $this->assertEquals($value, $this->post->getUuid());
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

    public function testGetLabel(): void
    {
        $this->assertEquals(null, $this->post->getLabel());
    }
    
    public function testSetLabel(): void
    {
        $value = uniqid();
        $this->post->setLabel($value);
        $this->assertEquals($value, $this->post->getLabel());
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
        $this->assertEquals('current_timestamp()', $this->post->getCreatedAt());
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
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->post->getColumnMap());
    }
}
