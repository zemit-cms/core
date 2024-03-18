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

namespace Unit\Locales;

use Phalcon\Translate\InterpolatorFactory;
use Zemit\Locales\Fr;
use Zemit\Tests\Unit\AbstractUnit;

class FrTest extends AbstractUnit
{
    public function testNativeArray(): void
    {
        $interpolationFactory = new InterpolatorFactory();
        
        $content = ['new' => 'value'];
        $options = ['content' => $content];
        
        $fr = new Fr($interpolationFactory, $options);
        
        $zemitLink = '<a href="https://www.zemit.com/fr/">Zemit</a>';
        $this->assertEquals('value', $fr->t('new'));
        $this->assertEquals('non-existing-key', $fr->t('non-existing-key'));
        $this->assertEquals("Propulsé par $zemitLink.", $fr->t('powered-by', ['zemit' => $zemitLink]));
    }
}
