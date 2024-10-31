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

namespace Zemit\Tests\Unit\Locales;

use Phalcon\Translate\InterpolatorFactory;
use Zemit\Locales\En;
use Zemit\Tests\Unit\AbstractUnit;

class EnTest extends AbstractUnit
{
    public function testNativeArray(): void
    {
        $interpolationFactory = new InterpolatorFactory();
        
        $content = ['new' => 'value'];
        $options = ['content' => $content];
        
        $en = new En($interpolationFactory, $options);
        
        $zemitLink = '<a href="https://www.zemit.com/">Zemit</a>';
        $this->assertEquals('value', $en->t('new'));
        $this->assertEquals('non-existing-key', $en->t('non-existing-key'));
        $this->assertEquals("Powered by $zemitLink.", $en->t('powered-by', ['zemit' => $zemitLink]));
    }
}
