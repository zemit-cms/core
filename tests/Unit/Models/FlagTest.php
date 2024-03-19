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

use Zemit\Models\Abstracts\FlagAbstract;
use Zemit\Models\Abstracts\Interfaces\FlagAbstractInterface;
use Zemit\Models\Flag;
use Zemit\Models\Interfaces\FlagInterface;

/**
 * Class FlagTest
 *
 * This class contains unit tests for the User class.
 */
class FlagTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public FlagInterface $flag;
    
    protected function setUp(): void
    {
        $this->flag = new Flag();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(Flag::class, $this->flag);
        $this->assertInstanceOf(FlagInterface::class, $this->flag);
    
        // Abstract
        $this->assertInstanceOf(FlagAbstract::class, $this->flag);
        $this->assertInstanceOf(FlagAbstractInterface::class, $this->flag);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->flag);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->flag);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->flag);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->flag);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->flag->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->flag->setId($value);
        $this->assertEquals($value, $this->flag->getId());
    }

    public function testGetSiteId(): void
    {
        $this->assertEquals(null, $this->flag->getSiteId());
    }
    
    public function testSetSiteId(): void
    {
        $value = uniqid();
        $this->flag->setSiteId($value);
        $this->assertEquals($value, $this->flag->getSiteId());
    }

    public function testGetPageId(): void
    {
        $this->assertEquals(null, $this->flag->getPageId());
    }
    
    public function testSetPageId(): void
    {
        $value = uniqid();
        $this->flag->setPageId($value);
        $this->assertEquals($value, $this->flag->getPageId());
    }

    public function testGetLangId(): void
    {
        $this->assertEquals(null, $this->flag->getLangId());
    }
    
    public function testSetLangId(): void
    {
        $value = uniqid();
        $this->flag->setLangId($value);
        $this->assertEquals($value, $this->flag->getLangId());
    }

    public function testGetLabel(): void
    {
        $this->assertEquals(null, $this->flag->getLabel());
    }
    
    public function testSetLabel(): void
    {
        $value = uniqid();
        $this->flag->setLabel($value);
        $this->assertEquals($value, $this->flag->getLabel());
    }

    public function testGetIndex(): void
    {
        $this->assertEquals(null, $this->flag->getIndex());
    }
    
    public function testSetIndex(): void
    {
        $value = uniqid();
        $this->flag->setIndex($value);
        $this->assertEquals($value, $this->flag->getIndex());
    }

    public function testGetValue(): void
    {
        $this->assertEquals(1, $this->flag->getValue());
    }
    
    public function testSetValue(): void
    {
        $value = uniqid();
        $this->flag->setValue($value);
        $this->assertEquals($value, $this->flag->getValue());
    }

    public function testGetMeta(): void
    {
        $this->assertEquals(null, $this->flag->getMeta());
    }
    
    public function testSetMeta(): void
    {
        $value = uniqid();
        $this->flag->setMeta($value);
        $this->assertEquals($value, $this->flag->getMeta());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->flag->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->flag->setDeleted($value);
        $this->assertEquals($value, $this->flag->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->flag->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->flag->setCreatedAt($value);
        $this->assertEquals($value, $this->flag->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->flag->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->flag->setCreatedBy($value);
        $this->assertEquals($value, $this->flag->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->flag->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->flag->setCreatedAs($value);
        $this->assertEquals($value, $this->flag->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->flag->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->flag->setUpdatedAt($value);
        $this->assertEquals($value, $this->flag->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->flag->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->flag->setUpdatedBy($value);
        $this->assertEquals($value, $this->flag->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->flag->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->flag->setUpdatedAs($value);
        $this->assertEquals($value, $this->flag->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->flag->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->flag->setDeletedAt($value);
        $this->assertEquals($value, $this->flag->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->flag->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->flag->setDeletedAs($value);
        $this->assertEquals($value, $this->flag->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->flag->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->flag->setDeletedBy($value);
        $this->assertEquals($value, $this->flag->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->flag->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->flag->setRestoredAt($value);
        $this->assertEquals($value, $this->flag->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->flag->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->flag->setRestoredBy($value);
        $this->assertEquals($value, $this->flag->getRestoredBy());
    }

    public function testGetRestoredAs(): void
    {
        $this->assertEquals(null, $this->flag->getRestoredAs());
    }
    
    public function testSetRestoredAs(): void
    {
        $value = uniqid();
        $this->flag->setRestoredAs($value);
        $this->assertEquals($value, $this->flag->getRestoredAs());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->flag->getColumnMap());
    }
}