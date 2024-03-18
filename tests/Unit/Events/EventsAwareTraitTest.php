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

namespace Unit\Events;

use Phalcon\Events\Event;
use Phalcon\Events\EventInterface;
use Phalcon\Events\Manager;
use Phalcon\Events\ManagerInterface;
use Zemit\Events\EventsAwareTrait;
use Zemit\Tests\Unit\AbstractUnit;

class EventsAwareTraitTest extends AbstractUnit
{
    public $events;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->events = new class {
            use EventsAwareTrait;
        };
    }
    
    public function testSetEventsManager(): void
    {
        $manager = new Manager();
        $this->events->setEventsManager($manager);
        $this->assertSame($manager, $this->events->getEventsManager());
    }
    
    public function testGetEventsManager(): void
    {
        $manager = $this->events->getEventsManager();
        $this->assertInstanceOf(ManagerInterface::class, $manager);
        $this->assertInstanceOf(Manager::class, $manager);
    }
    
    public function testGetEventsPrefix(): void
    {
        $this->assertIsString($this->events->getEventsPrefix());
        $this->assertNotEmpty($this->events->getEventsPrefix());
        $this->assertStringStartsWith('events-aware-trait-test-', $this->events->getEventsPrefix());
    }
    
    public function testSetEventsPrefix(): void
    {
        $this->events::setEventsPrefix('test');
        $this->assertEquals('test', $this->events->getEventsPrefix());
    }
    
    public function testFire(): void
    {
        $manager = new Manager();
        $data = ['data' => 'value'];
        $bag = ['event' => null, 'subject' => null, 'data' => null];
        $task = 'test';
        
        $manager->attach($this->events->getEventsPrefix() . ':' . $task, function ($event, $subject, $data) use (&$bag) {
            $bag = [
                'event' => $event,
                'subject' => $subject,
                'data' => $data,
            ];
        });
        
        $manager->attach($task, function ($event, $subject, $data) {
            return false;
        });
        
        $afterCancel = false;
        $manager->attach($task, function ($event, $subject, $data) use (&$afterCancel) {
            $afterCancel = true;
        });
        
        $this->events->setEventsManager($manager);
        $this->events->fire($task, $data, true);
        
        $this->assertInstanceOf(Event::class, $bag['event']);
        $this->assertInstanceOf(EventInterface::class, $bag['event']);
        $this->assertInstanceOf($this->events::class, $bag['subject']);
        $this->assertEquals($data, $bag['data']);
        $this->assertFalse($afterCancel);
    }
}
