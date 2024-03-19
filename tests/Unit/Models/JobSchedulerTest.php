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

use Zemit\Models\Abstracts\JobSchedulerAbstract;
use Zemit\Models\Abstracts\Interfaces\JobSchedulerAbstractInterface;
use Zemit\Models\JobScheduler;
use Zemit\Models\Interfaces\JobSchedulerInterface;

/**
 * Class JobSchedulerTest
 *
 * This class contains unit tests for the User class.
 */
class JobSchedulerTest extends \Zemit\Tests\Unit\AbstractUnit
{
    public JobSchedulerInterface $jobScheduler;
    
    protected function setUp(): void
    {
        $this->jobScheduler = new JobScheduler();
    }
    
    public function testInstanceOf(): void
    {
        // Model
        $this->assertInstanceOf(JobScheduler::class, $this->jobScheduler);
        $this->assertInstanceOf(JobSchedulerInterface::class, $this->jobScheduler);
    
        // Abstract
        $this->assertInstanceOf(JobSchedulerAbstract::class, $this->jobScheduler);
        $this->assertInstanceOf(JobSchedulerAbstractInterface::class, $this->jobScheduler);
        
        // Zemit
        $this->assertInstanceOf(\Zemit\Mvc\ModelInterface::class, $this->jobScheduler);
        $this->assertInstanceOf(\Zemit\Mvc\Model::class, $this->jobScheduler);
        
        // Phalcon
        $this->assertInstanceOf(\Phalcon\Mvc\ModelInterface::class, $this->jobScheduler);
        $this->assertInstanceOf(\Phalcon\Mvc\Model::class, $this->jobScheduler);
    }
    
    public function testGetId(): void
    {
        $this->assertEquals(null, $this->jobScheduler->getId());
    }
    
    public function testSetId(): void
    {
        $value = uniqid();
        $this->jobScheduler->setId($value);
        $this->assertEquals($value, $this->jobScheduler->getId());
    }

    public function testGetIndex(): void
    {
        $this->assertEquals(null, $this->jobScheduler->getIndex());
    }
    
    public function testSetIndex(): void
    {
        $value = uniqid();
        $this->jobScheduler->setIndex($value);
        $this->assertEquals($value, $this->jobScheduler->getIndex());
    }

    public function testGetLabel(): void
    {
        $this->assertEquals(null, $this->jobScheduler->getLabel());
    }
    
    public function testSetLabel(): void
    {
        $value = uniqid();
        $this->jobScheduler->setLabel($value);
        $this->assertEquals($value, $this->jobScheduler->getLabel());
    }

    public function testGetTask(): void
    {
        $this->assertEquals(null, $this->jobScheduler->getTask());
    }
    
    public function testSetTask(): void
    {
        $value = uniqid();
        $this->jobScheduler->setTask($value);
        $this->assertEquals($value, $this->jobScheduler->getTask());
    }

    public function testGetAction(): void
    {
        $this->assertEquals(null, $this->jobScheduler->getAction());
    }
    
    public function testSetAction(): void
    {
        $value = uniqid();
        $this->jobScheduler->setAction($value);
        $this->assertEquals($value, $this->jobScheduler->getAction());
    }

    public function testGetParams(): void
    {
        $this->assertEquals(null, $this->jobScheduler->getParams());
    }
    
    public function testSetParams(): void
    {
        $value = uniqid();
        $this->jobScheduler->setParams($value);
        $this->assertEquals($value, $this->jobScheduler->getParams());
    }

    public function testGetFrequency(): void
    {
        $this->assertEquals('manually', $this->jobScheduler->getFrequency());
    }
    
    public function testSetFrequency(): void
    {
        $value = uniqid();
        $this->jobScheduler->setFrequency($value);
        $this->assertEquals($value, $this->jobScheduler->getFrequency());
    }

    public function testGetStartingAt(): void
    {
        $this->assertEquals(null, $this->jobScheduler->getStartingAt());
    }
    
    public function testSetStartingAt(): void
    {
        $value = uniqid();
        $this->jobScheduler->setStartingAt($value);
        $this->assertEquals($value, $this->jobScheduler->getStartingAt());
    }

    public function testGetDeleted(): void
    {
        $this->assertEquals(null, $this->jobScheduler->getDeleted());
    }
    
    public function testSetDeleted(): void
    {
        $value = uniqid();
        $this->jobScheduler->setDeleted($value);
        $this->assertEquals($value, $this->jobScheduler->getDeleted());
    }

    public function testGetCreatedAt(): void
    {
        $this->assertEquals(null, $this->jobScheduler->getCreatedAt());
    }
    
    public function testSetCreatedAt(): void
    {
        $value = uniqid();
        $this->jobScheduler->setCreatedAt($value);
        $this->assertEquals($value, $this->jobScheduler->getCreatedAt());
    }

    public function testGetCreatedBy(): void
    {
        $this->assertEquals(null, $this->jobScheduler->getCreatedBy());
    }
    
    public function testSetCreatedBy(): void
    {
        $value = uniqid();
        $this->jobScheduler->setCreatedBy($value);
        $this->assertEquals($value, $this->jobScheduler->getCreatedBy());
    }

    public function testGetCreatedAs(): void
    {
        $this->assertEquals(null, $this->jobScheduler->getCreatedAs());
    }
    
    public function testSetCreatedAs(): void
    {
        $value = uniqid();
        $this->jobScheduler->setCreatedAs($value);
        $this->assertEquals($value, $this->jobScheduler->getCreatedAs());
    }

    public function testGetUpdatedAt(): void
    {
        $this->assertEquals(null, $this->jobScheduler->getUpdatedAt());
    }
    
    public function testSetUpdatedAt(): void
    {
        $value = uniqid();
        $this->jobScheduler->setUpdatedAt($value);
        $this->assertEquals($value, $this->jobScheduler->getUpdatedAt());
    }

    public function testGetUpdatedBy(): void
    {
        $this->assertEquals(null, $this->jobScheduler->getUpdatedBy());
    }
    
    public function testSetUpdatedBy(): void
    {
        $value = uniqid();
        $this->jobScheduler->setUpdatedBy($value);
        $this->assertEquals($value, $this->jobScheduler->getUpdatedBy());
    }

    public function testGetUpdatedAs(): void
    {
        $this->assertEquals(null, $this->jobScheduler->getUpdatedAs());
    }
    
    public function testSetUpdatedAs(): void
    {
        $value = uniqid();
        $this->jobScheduler->setUpdatedAs($value);
        $this->assertEquals($value, $this->jobScheduler->getUpdatedAs());
    }

    public function testGetDeletedAt(): void
    {
        $this->assertEquals(null, $this->jobScheduler->getDeletedAt());
    }
    
    public function testSetDeletedAt(): void
    {
        $value = uniqid();
        $this->jobScheduler->setDeletedAt($value);
        $this->assertEquals($value, $this->jobScheduler->getDeletedAt());
    }

    public function testGetDeletedAs(): void
    {
        $this->assertEquals(null, $this->jobScheduler->getDeletedAs());
    }
    
    public function testSetDeletedAs(): void
    {
        $value = uniqid();
        $this->jobScheduler->setDeletedAs($value);
        $this->assertEquals($value, $this->jobScheduler->getDeletedAs());
    }

    public function testGetDeletedBy(): void
    {
        $this->assertEquals(null, $this->jobScheduler->getDeletedBy());
    }
    
    public function testSetDeletedBy(): void
    {
        $value = uniqid();
        $this->jobScheduler->setDeletedBy($value);
        $this->assertEquals($value, $this->jobScheduler->getDeletedBy());
    }

    public function testGetRestoredAt(): void
    {
        $this->assertEquals(null, $this->jobScheduler->getRestoredAt());
    }
    
    public function testSetRestoredAt(): void
    {
        $value = uniqid();
        $this->jobScheduler->setRestoredAt($value);
        $this->assertEquals($value, $this->jobScheduler->getRestoredAt());
    }

    public function testGetRestoredBy(): void
    {
        $this->assertEquals(null, $this->jobScheduler->getRestoredBy());
    }
    
    public function testSetRestoredBy(): void
    {
        $value = uniqid();
        $this->jobScheduler->setRestoredBy($value);
        $this->assertEquals($value, $this->jobScheduler->getRestoredBy());
    }

    public function testGetRestoredAs(): void
    {
        $this->assertEquals(null, $this->jobScheduler->getRestoredAs());
    }
    
    public function testSetRestoredAs(): void
    {
        $value = uniqid();
        $this->jobScheduler->setRestoredAs($value);
        $this->assertEquals($value, $this->jobScheduler->getRestoredAs());
    }
    
    public function testGetColumnMapShouldBeAnArray(): void
    {
        $this->assertIsArray($this->jobScheduler->getColumnMap());
    }
}