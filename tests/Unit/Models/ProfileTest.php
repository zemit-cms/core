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

use Zemit\Models\Abstracts\ProfileAbstract;
use Zemit\Models\Abstracts\Interfaces\ProfileAbstractInterface;
use Zemit\Models\Profile;
use Zemit\Models\Interfaces\ProfileInterface;

/**
 * Class ProfileTest
 *
 * This class contains unit tests for the User class.
 */
class ProfileTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public ProfileInterface $profile;
    
    protected function setUp(): void
    {
        $this->profile = new Profile();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(Profile::class, $this->profile);
        $this->assertInstanceOf(ProfileInterface::class, $this->profile);
    
        // Abstract
        $this->assertInstanceOf(ProfileAbstract::class, $this->profile);
        $this->assertInstanceOf(ProfileAbstractInterface::class, $this->profile);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->profile);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->profile);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->profile);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->profile);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->profile->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->profile->setId($value);
        $this->assertEquals($value, $this->profile->getId());
    }

    public function testGetUserId(): void
    {
        $this->assertEquals(null, $this->profile->getUserId());
    }
    
    public function testSetUserId(): void
    {
        $value = uniqid();
        $this->profile->setUserId($value);
        $this->assertEquals($value, $this->profile->getUserId());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->profile->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->profile->setDeleted($value);
        $this->assertEquals($value, $this->profile->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->profile->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->profile->setCreatedAt($value);
        $this->assertEquals($value, $this->profile->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->profile->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->profile->setCreatedBy($value);
        $this->assertEquals($value, $this->profile->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->profile->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->profile->setCreatedAs($value);
        $this->assertEquals($value, $this->profile->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->profile->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->profile->setUpdatedAt($value);
        $this->assertEquals($value, $this->profile->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->profile->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->profile->setUpdatedBy($value);
        $this->assertEquals($value, $this->profile->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->profile->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->profile->setUpdatedAs($value);
        $this->assertEquals($value, $this->profile->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->profile->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->profile->setDeletedAt($value);
        $this->assertEquals($value, $this->profile->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->profile->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->profile->setDeletedAs($value);
        $this->assertEquals($value, $this->profile->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->profile->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->profile->setDeletedBy($value);
        $this->assertEquals($value, $this->profile->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->profile->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->profile->setRestoredAt($value);
        $this->assertEquals($value, $this->profile->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->profile->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->profile->setRestoredBy($value);
        $this->assertEquals($value, $this->profile->getRestoredBy());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->profile->getColumnMap());
    }
}
