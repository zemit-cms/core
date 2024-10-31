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

namespace Zemit\Tests\Unit\Fractal\Serializer;

use Zemit\Fractal\Serializer\RawArraySerializer;
use Zemit\Tests\Unit\AbstractUnit;

class RawArraySerializerTest extends AbstractUnit
{
    public RawArraySerializer $rawArraySerializer;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->rawArraySerializer = new RawArraySerializer();
    }
    
    public function testCollection(): void
    {
        $this->assertEquals([], $this->rawArraySerializer->collection('key', []));
    }
    
    public function testItem(): void
    {
        $this->assertEquals([], $this->rawArraySerializer->item('key', []));
    }
    
    public function testNull(): void
    {
        $this->assertEquals([], $this->rawArraySerializer->null());
    }
}
