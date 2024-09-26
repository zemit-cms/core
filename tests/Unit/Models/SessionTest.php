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

use Zemit\Models\Abstracts\SessionAbstract;
use Zemit\Models\Abstracts\Interfaces\SessionAbstractInterface;
use Zemit\Models\Session;
use Zemit\Models\Interfaces\SessionInterface;

/**
 * Class SessionTest
 *
 * This class contains unit tests for the User class.
 */
class SessionTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public SessionInterface $session;
    
    protected function setUp(): void
    {
        $this->session = new Session();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(Session::class, $this->session);
        $this->assertInstanceOf(SessionInterface::class, $this->session);
    
        // Abstract
        $this->assertInstanceOf(SessionAbstract::class, $this->session);
        $this->assertInstanceOf(SessionAbstractInterface::class, $this->session);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->session);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->session);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->session);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->session);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->session->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->session->setId($value);
        $this->assertEquals($value, $this->session->getId());
    }

    public function testGetUserId(): void
    {
        $this->assertEquals(null, $this->session->getUserId());
    }
    
    public function testSetUserId(): void
    {
        $value = uniqid();
        $this->session->setUserId($value);
        $this->assertEquals($value, $this->session->getUserId());
    }

    public function testGetAsUserId(): void
    {
        $this->assertEquals(null, $this->session->getAsUserId());
    }
    
    public function testSetAsUserId(): void
    {
        $value = uniqid();
        $this->session->setAsUserId($value);
        $this->assertEquals($value, $this->session->getAsUserId());
    }

    public function testGetKey(): void
    {
        $this->assertEquals(null, $this->session->getKey());
    }
    
    public function testSetKey(): void
    {
        $value = uniqid();
        $this->session->setKey($value);
        $this->assertEquals($value, $this->session->getKey());
    }

    public function testGetToken(): void
    {
        $this->assertEquals(null, $this->session->getToken());
    }
    
    public function testSetToken(): void
    {
        $value = uniqid();
        $this->session->setToken($value);
        $this->assertEquals($value, $this->session->getToken());
    }

    public function testGetJwt(): void
    {
        $this->assertEquals(null, $this->session->getJwt());
    }
    
    public function testSetJwt(): void
    {
        $value = uniqid();
        $this->session->setJwt($value);
        $this->assertEquals($value, $this->session->getJwt());
    }

    public function testGetMeta(): void
    {
        $this->assertEquals(null, $this->session->getMeta());
    }
    
    public function testSetMeta(): void
    {
        $value = uniqid();
        $this->session->setMeta($value);
        $this->assertEquals($value, $this->session->getMeta());
    }

    public function testGetDate(): void
    {
        $this->assertEquals(null, $this->session->getDate());
    }
    
    public function testSetDate(): void
    {
        $value = uniqid();
        $this->session->setDate($value);
        $this->assertEquals($value, $this->session->getDate());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->session->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->session->setDeleted($value);
        $this->assertEquals($value, $this->session->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->session->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->session->setCreatedAt($value);
        $this->assertEquals($value, $this->session->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->session->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->session->setCreatedBy($value);
        $this->assertEquals($value, $this->session->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->session->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->session->setCreatedAs($value);
        $this->assertEquals($value, $this->session->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->session->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->session->setUpdatedAt($value);
        $this->assertEquals($value, $this->session->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->session->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->session->setUpdatedBy($value);
        $this->assertEquals($value, $this->session->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->session->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->session->setUpdatedAs($value);
        $this->assertEquals($value, $this->session->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->session->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->session->setDeletedAt($value);
        $this->assertEquals($value, $this->session->getDeletedAt());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->session->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->session->setDeletedBy($value);
        $this->assertEquals($value, $this->session->getDeletedBy());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->session->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->session->setDeletedAs($value);
        $this->assertEquals($value, $this->session->getDeletedAs());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->session->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->session->setRestoredAt($value);
        $this->assertEquals($value, $this->session->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->session->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->session->setRestoredBy($value);
        $this->assertEquals($value, $this->session->getRestoredBy());
    }

    public function testGetRestoredAs(): void
    {
        $this->assertEquals(null, $this->session->getRestoredAs());
    }
    
    public function testSetRestoredAs(): void
    {
        $value = uniqid();
        $this->session->setRestoredAs($value);
        $this->assertEquals($value, $this->session->getRestoredAs());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->session->getColumnMap());
    }
}
