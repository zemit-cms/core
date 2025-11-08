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

namespace PhalconKit\Tests\Unit\Mvc;

use PhalconKit\Mvc\Url;
use PhalconKit\Tests\Unit\AbstractUnit;

class UrlTest extends AbstractUnit
{
    public function getUrl(): Url
    {
        return $this->bootstrap->di->get('url');
    }
    
    public function testUrl(): void
    {
        $tests = [
            'https://' => 'https://',
            'https://test' => 'https://test',
            'http://' => 'http://',
            'http://test' => 'http://test',
            '//' => '//',
            '//test' => '//test',
            '/' => '/',
            '/test' => '/test',
            '/test/../' => '/',
            '/test/../../' => '/',
            '/test/test/../../' => '/',
            '/test/test/..///../' => '/',
            '/test/./test/..///../' => '/',
            '/test/test/.././.././' => '/',
            '/test/test/.././.././////' => '/',
            '/test/test/test/.././.././////' => '/test',
            '/test/test/../' => '/test',
        ];
        
        foreach ($tests as $test => $result) {
            $this->assertEquals($result, $this->getUrl()->get($test));
        }
    }
}
