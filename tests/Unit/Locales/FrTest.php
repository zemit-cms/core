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
use PhalconKit\Locales\Fr;
use PhalconKit\Tests\Unit\AbstractUnit;

class FrTest extends AbstractUnit
{
    public function testNativeArray(): void
    {
        $interpolationFactory = new InterpolatorFactory();
        
        $content = ['new' => 'value'];
        $options = ['content' => $content];
        
        $fr = new Fr($interpolationFactory, $options);
        
        $phalconKitLink = '<a href="https://github.com/phalcon-kit/">Phalcon Kit</a>';
        $this->assertEquals('value', $fr->t('new'));
        $this->assertEquals('non-existing-key', $fr->t('non-existing-key'));
        $this->assertEquals("Propulsé par $phalconKitLink.", $fr->t('powered-by', ['phalcon-kit' => $phalconKitLink]));
    }
}
