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

namespace Unit;

use Zemit\Tests\Unit\AbstractUnit;
use Zemit\Url;

/**
 * Class UrlTest
 */
class UrlTest extends AbstractUnit
{
    public function getUrl(): Url {
        return $this->bootstrap->di->get('url');
    }
    
    public function testUrl() {
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
