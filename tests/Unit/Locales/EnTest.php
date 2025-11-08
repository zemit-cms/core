<?php

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit Team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PhalconKit\Tests\Unit\Locales;

use Phalcon\Translate\InterpolatorFactory;
use PhalconKit\Locales\En;
use PhalconKit\Tests\Unit\AbstractUnit;

class EnTest extends AbstractUnit
{
    public function testNativeArray(): void
    {
        $interpolationFactory = new InterpolatorFactory();
        
        $content = ['new' => 'value'];
        $options = ['content' => $content];
        
        $en = new En($interpolationFactory, $options);
        
        $phalconKitLink = '<a href="https://github.com/phalcon-kit/">Phalcon Kit</a>';
        $this->assertEquals('value', $en->t('new'));
        $this->assertEquals('non-existing-key', $en->t('non-existing-key'));
        $this->assertEquals("Powered by $phalconKitLink.", $en->t('powered-by', ['phalcon-kit' => $phalconKitLink]));
    }
}
