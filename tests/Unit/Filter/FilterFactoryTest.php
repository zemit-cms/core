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

namespace Unit\Filter;

use Zemit\Filter\Filter;
use Zemit\Filter\FilterFactory;
use Zemit\Tests\Unit\AbstractUnit;

class FilterFactoryTest extends AbstractUnit
{
    protected function setUp(): void
    {
    }
    
    public function testNewInstance(): void
    {
        $filterFactory = new FilterFactory();
        $this->assertInstanceOf(\Zemit\Filter\FilterFactory::class, $filterFactory);
        $this->assertInstanceOf(\Phalcon\Filter\FilterFactory::class, $filterFactory);
        
        $filter = $filterFactory->newInstance();
        $this->assertInstanceOf(\Zemit\Filter\Filter::class, $filter);
        $this->assertInstanceOf(\Phalcon\Filter\Filter::class, $filter);
    }
}
