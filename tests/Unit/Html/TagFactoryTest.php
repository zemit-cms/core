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

namespace Unit\Html;

use Zemit\Tests\Unit\AbstractUnit;

class TagFactoryTest extends AbstractUnit
{
//    public \Zemit\Html\TagFactory $tag;
    public \Zemit\Tag $tag;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->tag = $this->di->get('tag');
    }
    
    public function testTagFactoryFromDi(): void
    {
        $this->assertInstanceOf(\Zemit\Tag::class, $this->tag);
//        $this->assertInstanceOf(\Phalcon\Html\TagFactory::class, $this->tag); // @todo after switching from tag to TagFactory
//        $this->assertInstanceOf(\Zemit\Html\TagFactory::class, $this->tag); // @todo after switching from tag to TagFactory
    }
}
