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

    public function testGetUuid(): void
    {
        $this->assertEquals(null, $this->session->getUuid());
    }
    
    public function testSetUuid(): void
    {
        $value = uniqid();
        $this->session->setUuid($value);
        $this->assertEquals($value, $this->session->getUuid());
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

    public function testGetExpiresAt(): void
    {
        $this->assertEquals(null, $this->session->getExpiresAt());
    }
    
    public function testSetExpiresAt(): void
    {
        $value = uniqid();
        $this->session->setExpiresAt($value);
        $this->assertEquals($value, $this->session->getExpiresAt());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals('current_timestamp()', $this->session->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->session->setCreatedAt($value);
        $this->assertEquals($value, $this->session->getCreatedAt());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->session->getColumnMap());
    }
}
