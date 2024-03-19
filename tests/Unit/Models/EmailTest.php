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

use Zemit\Models\Abstracts\EmailAbstract;
use Zemit\Models\Abstracts\Interfaces\EmailAbstractInterface;
use Zemit\Models\Email;
use Zemit\Models\Interfaces\EmailInterface;

/**
 * Class EmailTest
 *
 * This class contains unit tests for the User class.
 */
class EmailTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public EmailInterface $email;
    
    protected function setUp(): void
    {
        $this->email = new Email();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(Email::class, $this->email);
        $this->assertInstanceOf(EmailInterface::class, $this->email);
    
        // Abstract
        $this->assertInstanceOf(EmailAbstract::class, $this->email);
        $this->assertInstanceOf(EmailAbstractInterface::class, $this->email);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->email);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->email);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->email);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->email);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->email->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->email->setId($value);
        $this->assertEquals($value, $this->email->getId());
    }

    public function testGetTemplateId(): void
    {
        $this->assertEquals(null, $this->email->getTemplateId());
    }
    
    public function testSetTemplateId(): void
    {
        $value = uniqid();
        $this->email->setTemplateId($value);
        $this->assertEquals($value, $this->email->getTemplateId());
    }

    public function testGetUuid(): void
    {
        $this->assertEquals(null, $this->email->getUuid());
    }
    
    public function testSetUuid(): void
    {
        $value = uniqid();
        $this->email->setUuid($value);
        $this->assertEquals($value, $this->email->getUuid());
    }

    public function testGetFrom(): void
    {
        $this->assertEquals(null, $this->email->getFrom());
    }
    
    public function testSetFrom(): void
    {
        $value = uniqid();
        $this->email->setFrom($value);
        $this->assertEquals($value, $this->email->getFrom());
    }

    public function testGetTo(): void
    {
        $this->assertEquals(null, $this->email->getTo());
    }
    
    public function testSetTo(): void
    {
        $value = uniqid();
        $this->email->setTo($value);
        $this->assertEquals($value, $this->email->getTo());
    }

    public function testGetCc(): void
    {
        $this->assertEquals(null, $this->email->getCc());
    }
    
    public function testSetCc(): void
    {
        $value = uniqid();
        $this->email->setCc($value);
        $this->assertEquals($value, $this->email->getCc());
    }

    public function testGetBcc(): void
    {
        $this->assertEquals(null, $this->email->getBcc());
    }
    
    public function testSetBcc(): void
    {
        $value = uniqid();
        $this->email->setBcc($value);
        $this->assertEquals($value, $this->email->getBcc());
    }

    public function testGetReadReceiptTo(): void
    {
        $this->assertEquals(null, $this->email->getReadReceiptTo());
    }
    
    public function testSetReadReceiptTo(): void
    {
        $value = uniqid();
        $this->email->setReadReceiptTo($value);
        $this->assertEquals($value, $this->email->getReadReceiptTo());
    }

    public function testGetSubject(): void
    {
        $this->assertEquals(null, $this->email->getSubject());
    }
    
    public function testSetSubject(): void
    {
        $value = uniqid();
        $this->email->setSubject($value);
        $this->assertEquals($value, $this->email->getSubject());
    }

    public function testGetContent(): void
    {
        $this->assertEquals(null, $this->email->getContent());
    }
    
    public function testSetContent(): void
    {
        $value = uniqid();
        $this->email->setContent($value);
        $this->assertEquals($value, $this->email->getContent());
    }

    public function testGetMeta(): void
    {
        $this->assertEquals(null, $this->email->getMeta());
    }
    
    public function testSetMeta(): void
    {
        $value = uniqid();
        $this->email->setMeta($value);
        $this->assertEquals($value, $this->email->getMeta());
    }

    public function testGetViewPath(): void
    {
        $this->assertEquals(null, $this->email->getViewPath());
    }
    
    public function testSetViewPath(): void
    {
        $value = uniqid();
        $this->email->setViewPath($value);
        $this->assertEquals($value, $this->email->getViewPath());
    }

    public function testGetSent(): void
    {
        $this->assertEquals(null, $this->email->getSent());
    }
    
    public function testSetSent(): void
    {
        $value = uniqid();
        $this->email->setSent($value);
        $this->assertEquals($value, $this->email->getSent());
    }

    public function testGetSentAt(): void
    {
        $this->assertEquals(null, $this->email->getSentAt());
    }
    
    public function testSetSentAt(): void
    {
        $value = uniqid();
        $this->email->setSentAt($value);
        $this->assertEquals($value, $this->email->getSentAt());
    }

    public function testGetSentBy(): void
    {
        $this->assertEquals(null, $this->email->getSentBy());
    }
    
    public function testSetSentBy(): void
    {
        $value = uniqid();
        $this->email->setSentBy($value);
        $this->assertEquals($value, $this->email->getSentBy());
    }

    public function testGetSentAs(): void
    {
        $this->assertEquals(null, $this->email->getSentAs());
    }
    
    public function testSetSentAs(): void
    {
        $value = uniqid();
        $this->email->setSentAs($value);
        $this->assertEquals($value, $this->email->getSentAs());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->email->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->email->setDeleted($value);
        $this->assertEquals($value, $this->email->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->email->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->email->setCreatedAt($value);
        $this->assertEquals($value, $this->email->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->email->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->email->setCreatedBy($value);
        $this->assertEquals($value, $this->email->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->email->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->email->setCreatedAs($value);
        $this->assertEquals($value, $this->email->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->email->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->email->setUpdatedAt($value);
        $this->assertEquals($value, $this->email->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->email->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->email->setUpdatedBy($value);
        $this->assertEquals($value, $this->email->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->email->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->email->setUpdatedAs($value);
        $this->assertEquals($value, $this->email->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->email->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->email->setDeletedAt($value);
        $this->assertEquals($value, $this->email->getDeletedAt());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->email->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->email->setDeletedBy($value);
        $this->assertEquals($value, $this->email->getDeletedBy());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->email->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->email->setDeletedAs($value);
        $this->assertEquals($value, $this->email->getDeletedAs());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->email->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->email->setRestoredAt($value);
        $this->assertEquals($value, $this->email->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->email->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->email->setRestoredBy($value);
        $this->assertEquals($value, $this->email->getRestoredBy());
    }

    public function testGetRestoredAs(): void
    {
        $this->assertEquals(null, $this->email->getRestoredAs());
    }
    
    public function testSetRestoredAs(): void
    {
        $value = uniqid();
        $this->email->setRestoredAs($value);
        $this->assertEquals($value, $this->email->getRestoredAs());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->email->getColumnMap());
    }
}