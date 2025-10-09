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

use Zemit\Models\Abstracts\TranslateFieldAbstract;
use Zemit\Models\Abstracts\Interfaces\TranslateFieldAbstractInterface;
use Zemit\Models\TranslateField;
use Zemit\Models\Interfaces\TranslateFieldInterface;

/**
 * Class TranslateFieldTest
 *
 * This class contains unit tests for the User class.
 */
class TranslateFieldTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public TranslateFieldInterface $translateField;
    
    protected function setUp(): void
    {
        $this->translateField = new TranslateField();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(TranslateField::class, $this->translateField);
        $this->assertInstanceOf(TranslateFieldInterface::class, $this->translateField);
    
        // Abstract
        $this->assertInstanceOf(TranslateFieldAbstract::class, $this->translateField);
        $this->assertInstanceOf(TranslateFieldAbstractInterface::class, $this->translateField);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->translateField);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->translateField);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->translateField);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->translateField);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->translateField->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->translateField->setId($value);
        $this->assertEquals($value, $this->translateField->getId());
    }

    public function testGetUuid(): void
    {
        $this->assertEquals(null, $this->translateField->getUuid());
    }
    
    public function testSetUuid(): void
    {
        $value = uniqid();
        $this->translateField->setUuid($value);
        $this->assertEquals($value, $this->translateField->getUuid());
    }

    public function testGetSiteId(): void
    {
        $this->assertEquals(null, $this->translateField->getSiteId());
    }
    
    public function testSetSiteId(): void
    {
        $value = uniqid();
        $this->translateField->setSiteId($value);
        $this->assertEquals($value, $this->translateField->getSiteId());
    }

    public function testGetLangId(): void
    {
        $this->assertEquals(null, $this->translateField->getLangId());
    }
    
    public function testSetLangId(): void
    {
        $value = uniqid();
        $this->translateField->setLangId($value);
        $this->assertEquals($value, $this->translateField->getLangId());
    }

    public function testGetTable(): void
    {
        $this->assertEquals(null, $this->translateField->getTable());
    }
    
    public function testSetTable(): void
    {
        $value = uniqid();
        $this->translateField->setTable($value);
        $this->assertEquals($value, $this->translateField->getTable());
    }

    public function testGetTableId(): void
    {
        $this->assertEquals(null, $this->translateField->getTableId());
    }
    
    public function testSetTableId(): void
    {
        $value = uniqid();
        $this->translateField->setTableId($value);
        $this->assertEquals($value, $this->translateField->getTableId());
    }

    public function testGetField(): void
    {
        $this->assertEquals(null, $this->translateField->getField());
    }
    
    public function testSetField(): void
    {
        $value = uniqid();
        $this->translateField->setField($value);
        $this->assertEquals($value, $this->translateField->getField());
    }

    public function testGetValue(): void
    {
        $this->assertEquals(null, $this->translateField->getValue());
    }
    
    public function testSetValue(): void
    {
        $value = uniqid();
        $this->translateField->setValue($value);
        $this->assertEquals($value, $this->translateField->getValue());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->translateField->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->translateField->setDeleted($value);
        $this->assertEquals($value, $this->translateField->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals('current_timestamp()', $this->translateField->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->translateField->setCreatedAt($value);
        $this->assertEquals($value, $this->translateField->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->translateField->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->translateField->setCreatedBy($value);
        $this->assertEquals($value, $this->translateField->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->translateField->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->translateField->setCreatedAs($value);
        $this->assertEquals($value, $this->translateField->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->translateField->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->translateField->setUpdatedAt($value);
        $this->assertEquals($value, $this->translateField->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->translateField->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->translateField->setUpdatedBy($value);
        $this->assertEquals($value, $this->translateField->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->translateField->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->translateField->setUpdatedAs($value);
        $this->assertEquals($value, $this->translateField->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->translateField->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->translateField->setDeletedAt($value);
        $this->assertEquals($value, $this->translateField->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->translateField->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->translateField->setDeletedAs($value);
        $this->assertEquals($value, $this->translateField->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->translateField->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->translateField->setDeletedBy($value);
        $this->assertEquals($value, $this->translateField->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->translateField->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->translateField->setRestoredAt($value);
        $this->assertEquals($value, $this->translateField->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->translateField->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->translateField->setRestoredBy($value);
        $this->assertEquals($value, $this->translateField->getRestoredBy());
    }

    public function testGetRestoredAs(): void
    {
        $this->assertEquals(null, $this->translateField->getRestoredAs());
    }
    
    public function testSetRestoredAs(): void
    {
        $value = uniqid();
        $this->translateField->setRestoredAs($value);
        $this->assertEquals($value, $this->translateField->getRestoredAs());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->translateField->getColumnMap());
    }
}
