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

use Zemit\Models\Abstracts\TranslateAbstract;
use Zemit\Models\Abstracts\Interfaces\TranslateAbstractInterface;
use Zemit\Models\Translate;
use Zemit\Models\Interfaces\TranslateInterface;

/**
 * Class TranslateTest
 *
 * This class contains unit tests for the User class.
 */
class TranslateTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public TranslateInterface $translate;
    
    protected function setUp(): void
    {
        $this->translate = new Translate();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(Translate::class, $this->translate);
        $this->assertInstanceOf(TranslateInterface::class, $this->translate);
    
        // Abstract
        $this->assertInstanceOf(TranslateAbstract::class, $this->translate);
        $this->assertInstanceOf(TranslateAbstractInterface::class, $this->translate);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->translate);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->translate);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->translate);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->translate);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->translate->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->translate->setId($value);
        $this->assertEquals($value, $this->translate->getId());
    }

    public function testGetLangId(): void
    {
        $this->assertEquals(null, $this->translate->getLangId());
    }
    
    public function testSetLangId(): void
    {
        $value = uniqid();
        $this->translate->setLangId($value);
        $this->assertEquals($value, $this->translate->getLangId());
    }

    public function testGetSiteId(): void
    {
        $this->assertEquals(null, $this->translate->getSiteId());
    }
    
    public function testSetSiteId(): void
    {
        $value = uniqid();
        $this->translate->setSiteId($value);
        $this->assertEquals($value, $this->translate->getSiteId());
    }

    public function testGetPageId(): void
    {
        $this->assertEquals(null, $this->translate->getPageId());
    }
    
    public function testSetPageId(): void
    {
        $value = uniqid();
        $this->translate->setPageId($value);
        $this->assertEquals($value, $this->translate->getPageId());
    }

    public function testGetPostId(): void
    {
        $this->assertEquals(null, $this->translate->getPostId());
    }
    
    public function testSetPostId(): void
    {
        $value = uniqid();
        $this->translate->setPostId($value);
        $this->assertEquals($value, $this->translate->getPostId());
    }

    public function testGetCategoryId(): void
    {
        $this->assertEquals(null, $this->translate->getCategoryId());
    }
    
    public function testSetCategoryId(): void
    {
        $value = uniqid();
        $this->translate->setCategoryId($value);
        $this->assertEquals($value, $this->translate->getCategoryId());
    }

    public function testGetKey(): void
    {
        $this->assertEquals(null, $this->translate->getKey());
    }
    
    public function testSetKey(): void
    {
        $value = uniqid();
        $this->translate->setKey($value);
        $this->assertEquals($value, $this->translate->getKey());
    }

    public function testGetValue(): void
    {
        $this->assertEquals(null, $this->translate->getValue());
    }
    
    public function testSetValue(): void
    {
        $value = uniqid();
        $this->translate->setValue($value);
        $this->assertEquals($value, $this->translate->getValue());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->translate->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->translate->setDeleted($value);
        $this->assertEquals($value, $this->translate->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->translate->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->translate->setCreatedAt($value);
        $this->assertEquals($value, $this->translate->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->translate->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->translate->setCreatedBy($value);
        $this->assertEquals($value, $this->translate->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->translate->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->translate->setCreatedAs($value);
        $this->assertEquals($value, $this->translate->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->translate->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->translate->setUpdatedAt($value);
        $this->assertEquals($value, $this->translate->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->translate->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->translate->setUpdatedBy($value);
        $this->assertEquals($value, $this->translate->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->translate->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->translate->setUpdatedAs($value);
        $this->assertEquals($value, $this->translate->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->translate->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->translate->setDeletedAt($value);
        $this->assertEquals($value, $this->translate->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->translate->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->translate->setDeletedAs($value);
        $this->assertEquals($value, $this->translate->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->translate->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->translate->setDeletedBy($value);
        $this->assertEquals($value, $this->translate->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->translate->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->translate->setRestoredAt($value);
        $this->assertEquals($value, $this->translate->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->translate->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->translate->setRestoredBy($value);
        $this->assertEquals($value, $this->translate->getRestoredBy());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->translate->getColumnMap());
    }
}
