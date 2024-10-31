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

namespace Zemit\Tests\Unit\Fractal;

use Zemit\Models\User;
use Zemit\Fractal\ModelTransformer;
use Zemit\Tests\Unit\AbstractUnit;
use Phalcon\Di\InjectionAwareInterface;

class ModelTransformerTest extends AbstractUnit
{
    public function testTransform(): void
    {
        $model = new User();
        $modelTransformer = new ModelTransformer();
        
        // act
        $transformed = $modelTransformer->transform($model);
        
        // asserts
        $this->assertIsArray($transformed);
        $this->assertEquals($transformed, $model->toArray());
        
        // transformer should be injection aware
        $this->assertInstanceOf(InjectionAwareInterface::class, $modelTransformer);
    }
}
