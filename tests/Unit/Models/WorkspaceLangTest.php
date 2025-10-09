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

use Zemit\Models\Abstracts\WorkspaceLangAbstract;
use Zemit\Models\Abstracts\Interfaces\WorkspaceLangAbstractInterface;
use Zemit\Models\WorkspaceLang;
use Zemit\Models\Interfaces\WorkspaceLangInterface;

/**
 * Class WorkspaceLangTest
 *
 * This class contains unit tests for the User class.
 */
class WorkspaceLangTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public WorkspaceLangInterface $workspaceLang;
    
    protected function setUp(): void
    {
        $this->workspaceLang = new WorkspaceLang();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(WorkspaceLang::class, $this->workspaceLang);
        $this->assertInstanceOf(WorkspaceLangInterface::class, $this->workspaceLang);
    
        // Abstract
        $this->assertInstanceOf(WorkspaceLangAbstract::class, $this->workspaceLang);
        $this->assertInstanceOf(WorkspaceLangAbstractInterface::class, $this->workspaceLang);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->workspaceLang);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->workspaceLang);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->workspaceLang);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->workspaceLang);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->workspaceLang->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->workspaceLang->setId($value);
        $this->assertEquals($value, $this->workspaceLang->getId());
    }

    public function testGetUuid(): void
    {
        $this->assertEquals(null, $this->workspaceLang->getUuid());
    }
    
    public function testSetUuid(): void
    {
        $value = uniqid();
        $this->workspaceLang->setUuid($value);
        $this->assertEquals($value, $this->workspaceLang->getUuid());
    }

    public function testGetWorkspaceId(): void
    {
        $this->assertEquals(null, $this->workspaceLang->getWorkspaceId());
    }
    
    public function testSetWorkspaceId(): void
    {
        $value = uniqid();
        $this->workspaceLang->setWorkspaceId($value);
        $this->assertEquals($value, $this->workspaceLang->getWorkspaceId());
    }

    public function testGetLangId(): void
    {
        $this->assertEquals(null, $this->workspaceLang->getLangId());
    }
    
    public function testSetLangId(): void
    {
        $value = uniqid();
        $this->workspaceLang->setLangId($value);
        $this->assertEquals($value, $this->workspaceLang->getLangId());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->workspaceLang->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->workspaceLang->setDeleted($value);
        $this->assertEquals($value, $this->workspaceLang->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals('current_timestamp()', $this->workspaceLang->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->workspaceLang->setCreatedAt($value);
        $this->assertEquals($value, $this->workspaceLang->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->workspaceLang->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->workspaceLang->setCreatedBy($value);
        $this->assertEquals($value, $this->workspaceLang->getCreatedBy());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->workspaceLang->getColumnMap());
    }
}
