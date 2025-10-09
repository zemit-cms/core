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

use Zemit\Models\Abstracts\UserAbstract;
use Zemit\Models\Abstracts\Interfaces\UserAbstractInterface;
use Zemit\Models\User;
use Zemit\Models\Interfaces\UserInterface;

/**
 * Class UserTest
 *
 * This class contains unit tests for the User class.
 */
class UserTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public UserInterface $user;
    
    protected function setUp(): void
    {
        $this->user = new User();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(User::class, $this->user);
        $this->assertInstanceOf(UserInterface::class, $this->user);
    
        // Abstract
        $this->assertInstanceOf(UserAbstract::class, $this->user);
        $this->assertInstanceOf(UserAbstractInterface::class, $this->user);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->user);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->user);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->user);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->user);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->user->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->user->setId($value);
        $this->assertEquals($value, $this->user->getId());
    }

    public function testGetUuid(): void
    {
        $this->assertEquals(null, $this->user->getUuid());
    }
    
    public function testSetUuid(): void
    {
        $value = uniqid();
        $this->user->setUuid($value);
        $this->assertEquals($value, $this->user->getUuid());
    }

    public function testGetEmail(): void
    {
        $this->assertEquals(null, $this->user->getEmail());
    }
    
    public function testSetEmail(): void
    {
        $value = uniqid();
        $this->user->setEmail($value);
        $this->assertEquals($value, $this->user->getEmail());
    }

    public function testGetPassword(): void
    {
        $this->assertEquals(null, $this->user->getPassword());
    }
    
    public function testSetPassword(): void
    {
        $value = uniqid();
        $this->user->setPassword($value);
        $this->assertEquals($value, $this->user->getPassword());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->user->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->user->setDeleted($value);
        $this->assertEquals($value, $this->user->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals('current_timestamp()', $this->user->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->user->setCreatedAt($value);
        $this->assertEquals($value, $this->user->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->user->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->user->setCreatedBy($value);
        $this->assertEquals($value, $this->user->getCreatedBy());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->user->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->user->setUpdatedAt($value);
        $this->assertEquals($value, $this->user->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->user->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->user->setUpdatedBy($value);
        $this->assertEquals($value, $this->user->getUpdatedBy());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->user->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->user->setDeletedAt($value);
        $this->assertEquals($value, $this->user->getDeletedAt());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->user->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->user->setDeletedBy($value);
        $this->assertEquals($value, $this->user->getDeletedBy());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->user->getColumnMap());
    }
}
