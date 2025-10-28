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

use Zemit\Models\Abstracts\SiteLangAbstract;
use Zemit\Models\Abstracts\Interfaces\SiteLangAbstractInterface;
use Zemit\Models\SiteLang;
use Zemit\Models\Interfaces\SiteLangInterface;

/**
 * Class SiteLangTest
 *
 * This class contains unit tests for the User class.
 */
class SiteLangTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public SiteLangInterface $siteLang;
    
    protected function setUp(): void
    {
        $this->siteLang = new SiteLang();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(SiteLang::class, $this->siteLang);
        $this->assertInstanceOf(SiteLangInterface::class, $this->siteLang);
    
        // Abstract
        $this->assertInstanceOf(SiteLangAbstract::class, $this->siteLang);
        $this->assertInstanceOf(SiteLangAbstractInterface::class, $this->siteLang);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->siteLang);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->siteLang);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->siteLang);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->siteLang);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->siteLang->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->siteLang->setId($value);
        $this->assertEquals($value, $this->siteLang->getId());
    }

    public function testGetUuid(): void
    {
        $this->assertEquals(null, $this->siteLang->getUuid());
    }
    
    public function testSetUuid(): void
    {
        $value = uniqid();
        $this->siteLang->setUuid($value);
        $this->assertEquals($value, $this->siteLang->getUuid());
    }

    public function testGetSiteId(): void
    {
        $this->assertEquals(null, $this->siteLang->getSiteId());
    }
    
    public function testSetSiteId(): void
    {
        $value = uniqid();
        $this->siteLang->setSiteId($value);
        $this->assertEquals($value, $this->siteLang->getSiteId());
    }

    public function testGetLangId(): void
    {
        $this->assertEquals(null, $this->siteLang->getLangId());
    }
    
    public function testSetLangId(): void
    {
        $value = uniqid();
        $this->siteLang->setLangId($value);
        $this->assertEquals($value, $this->siteLang->getLangId());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->siteLang->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->siteLang->setDeleted($value);
        $this->assertEquals($value, $this->siteLang->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals('current_timestamp()', $this->siteLang->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->siteLang->setCreatedAt($value);
        $this->assertEquals($value, $this->siteLang->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->siteLang->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->siteLang->setCreatedBy($value);
        $this->assertEquals($value, $this->siteLang->getCreatedBy());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->siteLang->getColumnMap());
    }
}
