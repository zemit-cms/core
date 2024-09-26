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

use Zemit\Models\Abstracts\ValidatorAbstract;
use Zemit\Models\Abstracts\Interfaces\ValidatorAbstractInterface;
use Zemit\Models\Validator;
use Zemit\Models\Interfaces\ValidatorInterface;

/**
 * Class ValidatorTest
 *
 * This class contains unit tests for the User class.
 */
class ValidatorTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public ValidatorInterface $validator;
    
    protected function setUp(): void
    {
        $this->validator = new Validator();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(Validator::class, $this->validator);
        $this->assertInstanceOf(ValidatorInterface::class, $this->validator);
    
        // Abstract
        $this->assertInstanceOf(ValidatorAbstract::class, $this->validator);
        $this->assertInstanceOf(ValidatorAbstractInterface::class, $this->validator);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->validator);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->validator);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->validator);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->validator);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->validator->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->validator->setId($value);
        $this->assertEquals($value, $this->validator->getId());
    }

    public function testGetFieldId(): void
    {
        $this->assertEquals(null, $this->validator->getFieldId());
    }
    
    public function testSetFieldId(): void
    {
        $value = uniqid();
        $this->validator->setFieldId($value);
        $this->assertEquals($value, $this->validator->getFieldId());
    }

    public function testGetName(): void
    {
        $this->assertEquals(null, $this->validator->getName());
    }
    
    public function testSetName(): void
    {
        $value = uniqid();
        $this->validator->setName($value);
        $this->assertEquals($value, $this->validator->getName());
    }

    public function testGetIndex(): void
    {
        $this->assertEquals(null, $this->validator->getIndex());
    }
    
    public function testSetIndex(): void
    {
        $value = uniqid();
        $this->validator->setIndex($value);
        $this->assertEquals($value, $this->validator->getIndex());
    }

    public function testGetType(): void
    {
        $this->assertEquals('text', $this->validator->getType());
    }
    
    public function testSetType(): void
    {
        $value = uniqid();
        $this->validator->setType($value);
        $this->assertEquals($value, $this->validator->getType());
    }

    public function testGetParams(): void
    {
        $this->assertEquals(null, $this->validator->getParams());
    }
    
    public function testSetParams(): void
    {
        $value = uniqid();
        $this->validator->setParams($value);
        $this->assertEquals($value, $this->validator->getParams());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->validator->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->validator->setDeleted($value);
        $this->assertEquals($value, $this->validator->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->validator->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->validator->setCreatedAt($value);
        $this->assertEquals($value, $this->validator->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->validator->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->validator->setCreatedBy($value);
        $this->assertEquals($value, $this->validator->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->validator->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->validator->setCreatedAs($value);
        $this->assertEquals($value, $this->validator->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->validator->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->validator->setUpdatedAt($value);
        $this->assertEquals($value, $this->validator->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->validator->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->validator->setUpdatedBy($value);
        $this->assertEquals($value, $this->validator->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->validator->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->validator->setUpdatedAs($value);
        $this->assertEquals($value, $this->validator->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->validator->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->validator->setDeletedAt($value);
        $this->assertEquals($value, $this->validator->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->validator->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->validator->setDeletedAs($value);
        $this->assertEquals($value, $this->validator->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->validator->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->validator->setDeletedBy($value);
        $this->assertEquals($value, $this->validator->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->validator->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->validator->setRestoredAt($value);
        $this->assertEquals($value, $this->validator->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->validator->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->validator->setRestoredBy($value);
        $this->assertEquals($value, $this->validator->getRestoredBy());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->validator->getColumnMap());
    }
}
