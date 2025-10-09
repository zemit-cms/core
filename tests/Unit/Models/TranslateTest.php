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

    public function testGetUuid(): void
    {
        $this->assertEquals(null, $this->translate->getUuid());
    }
    
    public function testSetUuid(): void
    {
        $value = uniqid();
        $this->translate->setUuid($value);
        $this->assertEquals($value, $this->translate->getUuid());
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

    public function testGetTranslatableTable(): void
    {
        $this->assertEquals(null, $this->translate->getTranslatableTable());
    }
    
    public function testSetTranslatableTable(): void
    {
        $value = uniqid();
        $this->translate->setTranslatableTable($value);
        $this->assertEquals($value, $this->translate->getTranslatableTable());
    }

    public function testGetTranslatableId(): void
    {
        $this->assertEquals(null, $this->translate->getTranslatableId());
    }
    
    public function testSetTranslatableId(): void
    {
        $value = uniqid();
        $this->translate->setTranslatableId($value);
        $this->assertEquals($value, $this->translate->getTranslatableId());
    }

    public function testGetField(): void
    {
        $this->assertEquals(null, $this->translate->getField());
    }
    
    public function testSetField(): void
    {
        $value = uniqid();
        $this->translate->setField($value);
        $this->assertEquals($value, $this->translate->getField());
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
        $this->assertEquals('current_timestamp()', $this->translate->getCreatedAt());
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
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->translate->getColumnMap());
    }
}
