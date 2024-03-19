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

use Zemit\Models\Abstracts\PageAbstract;
use Zemit\Models\Abstracts\Interfaces\PageAbstractInterface;
use Zemit\Models\Page;
use Zemit\Models\Interfaces\PageInterface;

/**
 * Class PageTest
 *
 * This class contains unit tests for the User class.
 */
class PageTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public PageInterface $page;
    
    protected function setUp(): void
    {
        $this->page = new Page();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(Page::class, $this->page);
        $this->assertInstanceOf(PageInterface::class, $this->page);
    
        // Abstract
        $this->assertInstanceOf(PageAbstract::class, $this->page);
        $this->assertInstanceOf(PageAbstractInterface::class, $this->page);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->page);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->page);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->page);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->page);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->page->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->page->setId($value);
        $this->assertEquals($value, $this->page->getId());
    }

    public function testGetLangId(): void
    {
        $this->assertEquals(null, $this->page->getLangId());
    }
    
    public function testSetLangId(): void
    {
        $value = uniqid();
        $this->page->setLangId($value);
        $this->assertEquals($value, $this->page->getLangId());
    }

    public function testGetSiteId(): void
    {
        $this->assertEquals(null, $this->page->getSiteId());
    }
    
    public function testSetSiteId(): void
    {
        $value = uniqid();
        $this->page->setSiteId($value);
        $this->assertEquals($value, $this->page->getSiteId());
    }

    public function testGetName(): void
    {
        $this->assertEquals(null, $this->page->getName());
    }
    
    public function testSetName(): void
    {
        $value = uniqid();
        $this->page->setName($value);
        $this->assertEquals($value, $this->page->getName());
    }

    public function testGetDescription(): void
    {
        $this->assertEquals(null, $this->page->getDescription());
    }
    
    public function testSetDescription(): void
    {
        $value = uniqid();
        $this->page->setDescription($value);
        $this->assertEquals($value, $this->page->getDescription());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->page->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->page->setDeleted($value);
        $this->assertEquals($value, $this->page->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->page->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->page->setCreatedAt($value);
        $this->assertEquals($value, $this->page->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->page->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->page->setCreatedBy($value);
        $this->assertEquals($value, $this->page->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->page->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->page->setCreatedAs($value);
        $this->assertEquals($value, $this->page->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->page->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->page->setUpdatedAt($value);
        $this->assertEquals($value, $this->page->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->page->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->page->setUpdatedBy($value);
        $this->assertEquals($value, $this->page->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->page->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->page->setUpdatedAs($value);
        $this->assertEquals($value, $this->page->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->page->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->page->setDeletedAt($value);
        $this->assertEquals($value, $this->page->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->page->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->page->setDeletedAs($value);
        $this->assertEquals($value, $this->page->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->page->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->page->setDeletedBy($value);
        $this->assertEquals($value, $this->page->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->page->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->page->setRestoredAt($value);
        $this->assertEquals($value, $this->page->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->page->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->page->setRestoredBy($value);
        $this->assertEquals($value, $this->page->getRestoredBy());
    }

    public function testGetRestoredAs(): void
    {
        $this->assertEquals(null, $this->page->getRestoredAs());
    }
    
    public function testSetRestoredAs(): void
    {
        $value = uniqid();
        $this->page->setRestoredAs($value);
        $this->assertEquals($value, $this->page->getRestoredAs());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->page->getColumnMap());
    }
}