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

use Zemit\Models\Abstracts\MetaAbstract;
use Zemit\Models\Abstracts\Interfaces\MetaAbstractInterface;
use Zemit\Models\Meta;
use Zemit\Models\Interfaces\MetaInterface;

/**
 * Class MetaTest
 *
 * This class contains unit tests for the User class.
 */
class MetaTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public MetaInterface $meta;
    
    protected function setUp(): void
    {
        $this->meta = new Meta();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(Meta::class, $this->meta);
        $this->assertInstanceOf(MetaInterface::class, $this->meta);
    
        // Abstract
        $this->assertInstanceOf(MetaAbstract::class, $this->meta);
        $this->assertInstanceOf(MetaAbstractInterface::class, $this->meta);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->meta);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->meta);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->meta);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->meta);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->meta->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->meta->setId($value);
        $this->assertEquals($value, $this->meta->getId());
    }

    public function testGetLangId(): void
    {
        $this->assertEquals(null, $this->meta->getLangId());
    }
    
    public function testSetLangId(): void
    {
        $value = uniqid();
        $this->meta->setLangId($value);
        $this->assertEquals($value, $this->meta->getLangId());
    }

    public function testGetSiteId(): void
    {
        $this->assertEquals(null, $this->meta->getSiteId());
    }
    
    public function testSetSiteId(): void
    {
        $value = uniqid();
        $this->meta->setSiteId($value);
        $this->assertEquals($value, $this->meta->getSiteId());
    }

    public function testGetPageId(): void
    {
        $this->assertEquals(null, $this->meta->getPageId());
    }
    
    public function testSetPageId(): void
    {
        $value = uniqid();
        $this->meta->setPageId($value);
        $this->assertEquals($value, $this->meta->getPageId());
    }

    public function testGetPostId(): void
    {
        $this->assertEquals(null, $this->meta->getPostId());
    }
    
    public function testSetPostId(): void
    {
        $value = uniqid();
        $this->meta->setPostId($value);
        $this->assertEquals($value, $this->meta->getPostId());
    }

    public function testGetCategoryId(): void
    {
        $this->assertEquals(null, $this->meta->getCategoryId());
    }
    
    public function testSetCategoryId(): void
    {
        $value = uniqid();
        $this->meta->setCategoryId($value);
        $this->assertEquals($value, $this->meta->getCategoryId());
    }

    public function testGetKey(): void
    {
        $this->assertEquals(null, $this->meta->getKey());
    }
    
    public function testSetKey(): void
    {
        $value = uniqid();
        $this->meta->setKey($value);
        $this->assertEquals($value, $this->meta->getKey());
    }

    public function testGetValue(): void
    {
        $this->assertEquals(null, $this->meta->getValue());
    }
    
    public function testSetValue(): void
    {
        $value = uniqid();
        $this->meta->setValue($value);
        $this->assertEquals($value, $this->meta->getValue());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->meta->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->meta->setDeleted($value);
        $this->assertEquals($value, $this->meta->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->meta->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->meta->setCreatedAt($value);
        $this->assertEquals($value, $this->meta->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->meta->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->meta->setCreatedBy($value);
        $this->assertEquals($value, $this->meta->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->meta->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->meta->setCreatedAs($value);
        $this->assertEquals($value, $this->meta->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->meta->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->meta->setUpdatedAt($value);
        $this->assertEquals($value, $this->meta->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->meta->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->meta->setUpdatedBy($value);
        $this->assertEquals($value, $this->meta->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->meta->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->meta->setUpdatedAs($value);
        $this->assertEquals($value, $this->meta->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->meta->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->meta->setDeletedAt($value);
        $this->assertEquals($value, $this->meta->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->meta->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->meta->setDeletedAs($value);
        $this->assertEquals($value, $this->meta->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->meta->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->meta->setDeletedBy($value);
        $this->assertEquals($value, $this->meta->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->meta->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->meta->setRestoredAt($value);
        $this->assertEquals($value, $this->meta->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->meta->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->meta->setRestoredBy($value);
        $this->assertEquals($value, $this->meta->getRestoredBy());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->meta->getColumnMap());
    }
}