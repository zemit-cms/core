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

use Zemit\Models\Abstracts\TemplateAbstract;
use Zemit\Models\Abstracts\Interfaces\TemplateAbstractInterface;
use Zemit\Models\Template;
use Zemit\Models\Interfaces\TemplateInterface;

/**
 * Class TemplateTest
 *
 * This class contains unit tests for the User class.
 */
class TemplateTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public TemplateInterface $template;
    
    protected function setUp(): void
    {
        $this->template = new Template();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(Template::class, $this->template);
        $this->assertInstanceOf(TemplateInterface::class, $this->template);
    
        // Abstract
        $this->assertInstanceOf(TemplateAbstract::class, $this->template);
        $this->assertInstanceOf(TemplateAbstractInterface::class, $this->template);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->template);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->template);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->template);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->template);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->template->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->template->setId($value);
        $this->assertEquals($value, $this->template->getId());
    }

    public function testGetIndex(): void
    {
        $this->assertEquals(null, $this->template->getIndex());
    }
    
    public function testSetIndex(): void
    {
        $value = uniqid();
        $this->template->setIndex($value);
        $this->assertEquals($value, $this->template->getIndex());
    }

    public function testGetLabel(): void
    {
        $this->assertEquals(null, $this->template->getLabel());
    }
    
    public function testSetLabel(): void
    {
        $value = uniqid();
        $this->template->setLabel($value);
        $this->assertEquals($value, $this->template->getLabel());
    }

    public function testGetSubject(): void
    {
        $this->assertEquals(null, $this->template->getSubject());
    }
    
    public function testSetSubject(): void
    {
        $value = uniqid();
        $this->template->setSubject($value);
        $this->assertEquals($value, $this->template->getSubject());
    }

    public function testGetContent(): void
    {
        $this->assertEquals(null, $this->template->getContent());
    }
    
    public function testSetContent(): void
    {
        $value = uniqid();
        $this->template->setContent($value);
        $this->assertEquals($value, $this->template->getContent());
    }

    public function testGetMeta(): void
    {
        $this->assertEquals(null, $this->template->getMeta());
    }
    
    public function testSetMeta(): void
    {
        $value = uniqid();
        $this->template->setMeta($value);
        $this->assertEquals($value, $this->template->getMeta());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->template->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->template->setDeleted($value);
        $this->assertEquals($value, $this->template->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->template->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->template->setCreatedAt($value);
        $this->assertEquals($value, $this->template->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->template->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->template->setCreatedBy($value);
        $this->assertEquals($value, $this->template->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->template->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->template->setCreatedAs($value);
        $this->assertEquals($value, $this->template->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->template->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->template->setUpdatedAt($value);
        $this->assertEquals($value, $this->template->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->template->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->template->setUpdatedBy($value);
        $this->assertEquals($value, $this->template->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->template->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->template->setUpdatedAs($value);
        $this->assertEquals($value, $this->template->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->template->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->template->setDeletedAt($value);
        $this->assertEquals($value, $this->template->getDeletedAt());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->template->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->template->setDeletedBy($value);
        $this->assertEquals($value, $this->template->getDeletedBy());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->template->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->template->setDeletedAs($value);
        $this->assertEquals($value, $this->template->getDeletedAs());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->template->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->template->setRestoredAt($value);
        $this->assertEquals($value, $this->template->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->template->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->template->setRestoredBy($value);
        $this->assertEquals($value, $this->template->getRestoredBy());
    }

    public function testGetRestoredAs(): void
    {
        $this->assertEquals(null, $this->template->getRestoredAs());
    }
    
    public function testSetRestoredAs(): void
    {
        $value = uniqid();
        $this->template->setRestoredAs($value);
        $this->assertEquals($value, $this->template->getRestoredAs());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->template->getColumnMap());
    }
}