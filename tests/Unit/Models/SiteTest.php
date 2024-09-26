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

use Zemit\Models\Abstracts\SiteAbstract;
use Zemit\Models\Abstracts\Interfaces\SiteAbstractInterface;
use Zemit\Models\Site;
use Zemit\Models\Interfaces\SiteInterface;

/**
 * Class SiteTest
 *
 * This class contains unit tests for the User class.
 */
class SiteTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public SiteInterface $site;
    
    protected function setUp(): void
    {
        $this->site = new Site();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(Site::class, $this->site);
        $this->assertInstanceOf(SiteInterface::class, $this->site);
    
        // Abstract
        $this->assertInstanceOf(SiteAbstract::class, $this->site);
        $this->assertInstanceOf(SiteAbstractInterface::class, $this->site);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->site);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->site);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->site);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->site);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->site->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->site->setId($value);
        $this->assertEquals($value, $this->site->getId());
    }

    public function testGetUuid(): void
    {
        $this->assertEquals(null, $this->site->getUuid());
    }
    
    public function testSetUuid(): void
    {
        $value = uniqid();
        $this->site->setUuid($value);
        $this->assertEquals($value, $this->site->getUuid());
    }

    public function testGetName(): void
    {
        $this->assertEquals(null, $this->site->getName());
    }
    
    public function testSetName(): void
    {
        $value = uniqid();
        $this->site->setName($value);
        $this->assertEquals($value, $this->site->getName());
    }

    public function testGetDescription(): void
    {
        $this->assertEquals(null, $this->site->getDescription());
    }
    
    public function testSetDescription(): void
    {
        $value = uniqid();
        $this->site->setDescription($value);
        $this->assertEquals($value, $this->site->getDescription());
    }

    public function testGetIcon(): void
    {
        $this->assertEquals(null, $this->site->getIcon());
    }
    
    public function testSetIcon(): void
    {
        $value = uniqid();
        $this->site->setIcon($value);
        $this->assertEquals($value, $this->site->getIcon());
    }

    public function testGetColor(): void
    {
        $this->assertEquals(null, $this->site->getColor());
    }
    
    public function testSetColor(): void
    {
        $value = uniqid();
        $this->site->setColor($value);
        $this->assertEquals($value, $this->site->getColor());
    }

    public function testGetStatus(): void
    {
        $this->assertEquals('active', $this->site->getStatus());
    }
    
    public function testSetStatus(): void
    {
        $value = uniqid();
        $this->site->setStatus($value);
        $this->assertEquals($value, $this->site->getStatus());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->site->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->site->setDeleted($value);
        $this->assertEquals($value, $this->site->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->site->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->site->setCreatedAt($value);
        $this->assertEquals($value, $this->site->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->site->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->site->setCreatedBy($value);
        $this->assertEquals($value, $this->site->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->site->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->site->setCreatedAs($value);
        $this->assertEquals($value, $this->site->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->site->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->site->setUpdatedAt($value);
        $this->assertEquals($value, $this->site->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->site->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->site->setUpdatedBy($value);
        $this->assertEquals($value, $this->site->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->site->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->site->setUpdatedAs($value);
        $this->assertEquals($value, $this->site->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->site->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->site->setDeletedAt($value);
        $this->assertEquals($value, $this->site->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->site->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->site->setDeletedAs($value);
        $this->assertEquals($value, $this->site->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->site->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->site->setDeletedBy($value);
        $this->assertEquals($value, $this->site->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->site->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->site->setRestoredAt($value);
        $this->assertEquals($value, $this->site->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->site->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->site->setRestoredBy($value);
        $this->assertEquals($value, $this->site->getRestoredBy());
    }

    public function testGetRestoredAs(): void
    {
        $this->assertEquals(null, $this->site->getRestoredAs());
    }
    
    public function testSetRestoredAs(): void
    {
        $value = uniqid();
        $this->site->setRestoredAs($value);
        $this->assertEquals($value, $this->site->getRestoredAs());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->site->getColumnMap());
    }
}
