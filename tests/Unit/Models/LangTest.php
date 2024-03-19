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

use Zemit\Models\Abstracts\LangAbstract;
use Zemit\Models\Abstracts\Interfaces\LangAbstractInterface;
use Zemit\Models\Lang;
use Zemit\Models\Interfaces\LangInterface;

/**
 * Class LangTest
 *
 * This class contains unit tests for the User class.
 */
class LangTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public LangInterface $lang;
    
    protected function setUp(): void
    {
        $this->lang = new Lang();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(Lang::class, $this->lang);
        $this->assertInstanceOf(LangInterface::class, $this->lang);
    
        // Abstract
        $this->assertInstanceOf(LangAbstract::class, $this->lang);
        $this->assertInstanceOf(LangAbstractInterface::class, $this->lang);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->lang);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->lang);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->lang);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->lang);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->lang->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->lang->setId($value);
        $this->assertEquals($value, $this->lang->getId());
    }

    public function testGetLabel(): void
    {
        $this->assertEquals(null, $this->lang->getLabel());
    }
    
    public function testSetLabel(): void
    {
        $value = uniqid();
        $this->lang->setLabel($value);
        $this->assertEquals($value, $this->lang->getLabel());
    }

    public function testGetCode(): void
    {
        $this->assertEquals(null, $this->lang->getCode());
    }
    
    public function testSetCode(): void
    {
        $value = uniqid();
        $this->lang->setCode($value);
        $this->assertEquals($value, $this->lang->getCode());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->lang->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->lang->setDeleted($value);
        $this->assertEquals($value, $this->lang->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->lang->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->lang->setCreatedAt($value);
        $this->assertEquals($value, $this->lang->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->lang->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->lang->setCreatedBy($value);
        $this->assertEquals($value, $this->lang->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->lang->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->lang->setCreatedAs($value);
        $this->assertEquals($value, $this->lang->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->lang->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->lang->setUpdatedAt($value);
        $this->assertEquals($value, $this->lang->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->lang->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->lang->setUpdatedBy($value);
        $this->assertEquals($value, $this->lang->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->lang->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->lang->setUpdatedAs($value);
        $this->assertEquals($value, $this->lang->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->lang->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->lang->setDeletedAt($value);
        $this->assertEquals($value, $this->lang->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->lang->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->lang->setDeletedAs($value);
        $this->assertEquals($value, $this->lang->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->lang->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->lang->setDeletedBy($value);
        $this->assertEquals($value, $this->lang->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->lang->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->lang->setRestoredAt($value);
        $this->assertEquals($value, $this->lang->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->lang->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->lang->setRestoredBy($value);
        $this->assertEquals($value, $this->lang->getRestoredBy());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->lang->getColumnMap());
    }
}