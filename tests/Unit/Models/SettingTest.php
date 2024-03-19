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

use Zemit\Models\Abstracts\SettingAbstract;
use Zemit\Models\Abstracts\Interfaces\SettingAbstractInterface;
use Zemit\Models\Setting;
use Zemit\Models\Interfaces\SettingInterface;

/**
 * Class SettingTest
 *
 * This class contains unit tests for the User class.
 */
class SettingTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public SettingInterface $setting;
    
    protected function setUp(): void
    {
        $this->setting = new Setting();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(Setting::class, $this->setting);
        $this->assertInstanceOf(SettingInterface::class, $this->setting);
    
        // Abstract
        $this->assertInstanceOf(SettingAbstract::class, $this->setting);
        $this->assertInstanceOf(SettingAbstractInterface::class, $this->setting);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->setting);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->setting);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->setting);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->setting);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->setting->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->setting->setId($value);
        $this->assertEquals($value, $this->setting->getId());
    }

    public function testGetCategory(): void
    {
        $this->assertEquals(null, $this->setting->getCategory());
    }
    
    public function testSetCategory(): void
    {
        $value = uniqid();
        $this->setting->setCategory($value);
        $this->assertEquals($value, $this->setting->getCategory());
    }

    public function testGetIndex(): void
    {
        $this->assertEquals(null, $this->setting->getIndex());
    }
    
    public function testSetIndex(): void
    {
        $value = uniqid();
        $this->setting->setIndex($value);
        $this->assertEquals($value, $this->setting->getIndex());
    }

    public function testGetLabel(): void
    {
        $this->assertEquals(null, $this->setting->getLabel());
    }
    
    public function testSetLabel(): void
    {
        $value = uniqid();
        $this->setting->setLabel($value);
        $this->assertEquals($value, $this->setting->getLabel());
    }

    public function testGetValue(): void
    {
        $this->assertEquals(null, $this->setting->getValue());
    }
    
    public function testSetValue(): void
    {
        $value = uniqid();
        $this->setting->setValue($value);
        $this->assertEquals($value, $this->setting->getValue());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->setting->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->setting->setDeleted($value);
        $this->assertEquals($value, $this->setting->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->setting->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->setting->setCreatedAt($value);
        $this->assertEquals($value, $this->setting->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->setting->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->setting->setCreatedBy($value);
        $this->assertEquals($value, $this->setting->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->setting->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->setting->setCreatedAs($value);
        $this->assertEquals($value, $this->setting->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->setting->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->setting->setUpdatedAt($value);
        $this->assertEquals($value, $this->setting->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->setting->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->setting->setUpdatedBy($value);
        $this->assertEquals($value, $this->setting->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->setting->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->setting->setUpdatedAs($value);
        $this->assertEquals($value, $this->setting->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->setting->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->setting->setDeletedAt($value);
        $this->assertEquals($value, $this->setting->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->setting->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->setting->setDeletedAs($value);
        $this->assertEquals($value, $this->setting->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->setting->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->setting->setDeletedBy($value);
        $this->assertEquals($value, $this->setting->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->setting->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->setting->setRestoredAt($value);
        $this->assertEquals($value, $this->setting->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->setting->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->setting->setRestoredBy($value);
        $this->assertEquals($value, $this->setting->getRestoredBy());
    }

    public function testGetRestoredAs(): void
    {
        $this->assertEquals(null, $this->setting->getRestoredAs());
    }
    
    public function testSetRestoredAs(): void
    {
        $value = uniqid();
        $this->setting->setRestoredAs($value);
        $this->assertEquals($value, $this->setting->getRestoredAs());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->setting->getColumnMap());
    }
}