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

use Zemit\Models\Abstracts\SiteLangAbstract;
use Zemit\Models\Abstracts\Interfaces\SiteLangAbstractInterface;
use Zemit\Models\SiteLang;
use Zemit\Models\Interfaces\SiteLangInterface;

/**
 * Class SiteLangTest
 *
 * This class contains unit tests for the User class.
 */
class SiteLangTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public SiteLangInterface $siteLang;
    
    protected function setUp(): void
    {
        $this->siteLang = new SiteLang();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(SiteLang::class, $this->siteLang);
        $this->assertInstanceOf(SiteLangInterface::class, $this->siteLang);
    
        // Abstract
        $this->assertInstanceOf(SiteLangAbstract::class, $this->siteLang);
        $this->assertInstanceOf(SiteLangAbstractInterface::class, $this->siteLang);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->siteLang);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->siteLang);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->siteLang);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->siteLang);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->siteLang->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->siteLang->setId($value);
        $this->assertEquals($value, $this->siteLang->getId());
    }

    public function testGetSiteId(): void
    {
        $this->assertEquals(null, $this->siteLang->getSiteId());
    }
    
    public function testSetSiteId(): void
    {
        $value = uniqid();
        $this->siteLang->setSiteId($value);
        $this->assertEquals($value, $this->siteLang->getSiteId());
    }

    public function testGetLangId(): void
    {
        $this->assertEquals(null, $this->siteLang->getLangId());
    }
    
    public function testSetLangId(): void
    {
        $value = uniqid();
        $this->siteLang->setLangId($value);
        $this->assertEquals($value, $this->siteLang->getLangId());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->siteLang->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->siteLang->setDeleted($value);
        $this->assertEquals($value, $this->siteLang->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->siteLang->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->siteLang->setCreatedAt($value);
        $this->assertEquals($value, $this->siteLang->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->siteLang->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->siteLang->setCreatedBy($value);
        $this->assertEquals($value, $this->siteLang->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->siteLang->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->siteLang->setCreatedAs($value);
        $this->assertEquals($value, $this->siteLang->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->siteLang->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->siteLang->setUpdatedAt($value);
        $this->assertEquals($value, $this->siteLang->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->siteLang->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->siteLang->setUpdatedBy($value);
        $this->assertEquals($value, $this->siteLang->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->siteLang->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->siteLang->setUpdatedAs($value);
        $this->assertEquals($value, $this->siteLang->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->siteLang->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->siteLang->setDeletedAt($value);
        $this->assertEquals($value, $this->siteLang->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->siteLang->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->siteLang->setDeletedAs($value);
        $this->assertEquals($value, $this->siteLang->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->siteLang->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->siteLang->setDeletedBy($value);
        $this->assertEquals($value, $this->siteLang->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->siteLang->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->siteLang->setRestoredAt($value);
        $this->assertEquals($value, $this->siteLang->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->siteLang->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->siteLang->setRestoredBy($value);
        $this->assertEquals($value, $this->siteLang->getRestoredBy());
    }

    public function testGetDeletedCopy1(): void
    {
        $this->assertEquals(null, $this->siteLang->getDeletedCopy1());
    }
    
    public function testSetDeletedCopy1(): void
    {
        $value = uniqid();
        $this->siteLang->setDeletedCopy1($value);
        $this->assertEquals($value, $this->siteLang->getDeletedCopy1());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->siteLang->getColumnMap());
    }
}
