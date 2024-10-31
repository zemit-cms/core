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

namespace Zemit\Tests\Unit\Mvc;

use Zemit\Mvc\Url;
use Zemit\Tests\Unit\AbstractUnit;

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
            'https://zemit.com' => 'https://zemit.com',
            
            // @todo fix these ones
//            'https://zemit.com/test/../' => 'https://zemit.com/',
//            'https://zemit.com/test/../../' => 'https://zemit.com/',
//            'https://zemit.com/test/test/../../' => 'https://zemit.com/',
//            'http://zemit.com/test/test/.././.././////' => 'http://zemit.com/test' 
        ];
        
        foreach ($tests as $test => $result) {
            $this->assertEquals($result, $this->getUrl()->get($test));
        }
    }
}
