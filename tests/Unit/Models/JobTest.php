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

use Zemit\Models\Abstracts\JobAbstract;
use Zemit\Models\Abstracts\Interfaces\JobAbstractInterface;
use Zemit\Models\Job;
use Zemit\Models\Interfaces\JobInterface;

/**
 * Class JobTest
 *
 * This class contains unit tests for the User class.
 */
class JobTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public JobInterface $job;
    
    protected function setUp(): void
    {
        $this->job = new Job();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(Job::class, $this->job);
        $this->assertInstanceOf(JobInterface::class, $this->job);
    
        // Abstract
        $this->assertInstanceOf(JobAbstract::class, $this->job);
        $this->assertInstanceOf(JobAbstractInterface::class, $this->job);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->job);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->job);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->job);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->job);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->job->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->job->setId($value);
        $this->assertEquals($value, $this->job->getId());
    }

    public function testGetUuid(): void
    {
        $this->assertEquals(null, $this->job->getUuid());
    }
    
    public function testSetUuid(): void
    {
        $value = uniqid();
        $this->job->setUuid($value);
        $this->assertEquals($value, $this->job->getUuid());
    }

    public function testGetLabel(): void
    {
        $this->assertEquals(null, $this->job->getLabel());
    }
    
    public function testSetLabel(): void
    {
        $value = uniqid();
        $this->job->setLabel($value);
        $this->assertEquals($value, $this->job->getLabel());
    }

    public function testGetTask(): void
    {
        $this->assertEquals(null, $this->job->getTask());
    }
    
    public function testSetTask(): void
    {
        $value = uniqid();
        $this->job->setTask($value);
        $this->assertEquals($value, $this->job->getTask());
    }

    public function testGetAction(): void
    {
        $this->assertEquals(null, $this->job->getAction());
    }
    
    public function testSetAction(): void
    {
        $value = uniqid();
        $this->job->setAction($value);
        $this->assertEquals($value, $this->job->getAction());
    }

    public function testGetParams(): void
    {
        $this->assertEquals(null, $this->job->getParams());
    }
    
    public function testSetParams(): void
    {
        $value = uniqid();
        $this->job->setParams($value);
        $this->assertEquals($value, $this->job->getParams());
    }

    public function testGetThread(): void
    {
        $this->assertEquals(null, $this->job->getThread());
    }
    
    public function testSetThread(): void
    {
        $value = uniqid();
        $this->job->setThread($value);
        $this->assertEquals($value, $this->job->getThread());
    }

    public function testGetPriority(): void
    {
        $this->assertEquals(null, $this->job->getPriority());
    }
    
    public function testSetPriority(): void
    {
        $value = uniqid();
        $this->job->setPriority($value);
        $this->assertEquals($value, $this->job->getPriority());
    }

    public function testGetAt(): void
    {
        $this->assertEquals(null, $this->job->getAt());
    }
    
    public function testSetAt(): void
    {
        $value = uniqid();
        $this->job->setAt($value);
        $this->assertEquals($value, $this->job->getAt());
    }

    public function testGetStatus(): void
    {
        $this->assertEquals('new', $this->job->getStatus());
    }
    
    public function testSetStatus(): void
    {
        $value = uniqid();
        $this->job->setStatus($value);
        $this->assertEquals($value, $this->job->getStatus());
    }

    public function testGetResult(): void
    {
        $this->assertEquals(null, $this->job->getResult());
    }
    
    public function testSetResult(): void
    {
        $value = uniqid();
        $this->job->setResult($value);
        $this->assertEquals($value, $this->job->getResult());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->job->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->job->setDeleted($value);
        $this->assertEquals($value, $this->job->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->job->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->job->setCreatedAt($value);
        $this->assertEquals($value, $this->job->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->job->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->job->setCreatedBy($value);
        $this->assertEquals($value, $this->job->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->job->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->job->setCreatedAs($value);
        $this->assertEquals($value, $this->job->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->job->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->job->setUpdatedAt($value);
        $this->assertEquals($value, $this->job->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->job->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->job->setUpdatedBy($value);
        $this->assertEquals($value, $this->job->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->job->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->job->setUpdatedAs($value);
        $this->assertEquals($value, $this->job->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->job->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->job->setDeletedAt($value);
        $this->assertEquals($value, $this->job->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->job->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->job->setDeletedAs($value);
        $this->assertEquals($value, $this->job->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->job->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->job->setDeletedBy($value);
        $this->assertEquals($value, $this->job->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->job->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->job->setRestoredAt($value);
        $this->assertEquals($value, $this->job->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->job->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->job->setRestoredBy($value);
        $this->assertEquals($value, $this->job->getRestoredBy());
    }

    public function testGetRestoredAs(): void
    {
        $this->assertEquals(null, $this->job->getRestoredAs());
    }
    
    public function testSetRestoredAs(): void
    {
        $value = uniqid();
        $this->job->setRestoredAs($value);
        $this->assertEquals($value, $this->job->getRestoredAs());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->job->getColumnMap());
    }
}
