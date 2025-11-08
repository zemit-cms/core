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

namespace PhalconKit\Tests\Unit\Filter;

use PhalconKit\Filter\Filter;
use PhalconKit\Tests\Unit\AbstractUnit;

class FilterTest extends AbstractUnit
{
    protected \PhalconKit\Filter\Filter $filter;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->filter = $this->di->get('filter');
    }
    
    public function testFilterFromDi(): void
    {
        $this->assertInstanceOf(\PhalconKit\Filter\Filter::class, $this->filter);
        
        $this->assertInstanceOf(\Phalcon\Filter\Filter::class, $this->filter);
        $this->assertInstanceOf(\Phalcon\Filter\FilterInterface::class, $this->filter);
    }
    
    public function testMd5(): void
    {
        for ($i = 0; $i < 20; $i++) {
            $md5 = md5(uniqid());
            $this->assertSame($md5, $this->filter->sanitize($md5, [Filter::FILTER_MD5]));
            $this->assertSame($md5, $this->filter->sanitize('!' . $md5, [Filter::FILTER_MD5]));
        }
    }
    
    public function testJson(): void
    {
        $this->assertSame(null, $this->filter->sanitize(null, [Filter::FILTER_JSON]));
        for ($i = 0; $i < 20; $i++) {
            $json = json_encode(uniqid());
            $this->assertSame($json, $this->filter->sanitize($json, [Filter::FILTER_JSON]));
            $this->assertSame(null, $this->filter->sanitize('!' . $json, [Filter::FILTER_JSON]));
        }
    }
    
    public function testIpv6(): void
    {
        $tests = [
            '1d55:0781:0a32:d630:908f:c73a:ed07:6372',
            'd5e7:ae01:68d1:71eb:33f8:ee90:5719:6187',
            '390d:0cbe:ca62:deed:09fa:8ea0:7c3a:d5b7',
            '7a03:0d47:5e4a:bf67:997b:cd7f:ad39:cbac',
            'a64d:4368:730d:b6dc:5e50:3c44:e7ef:430b',
            'aaf7:b4ae:a6bb:9d97:6c5d:075a:4662:89a6',
            '193d:1f8a:d425:7945:a836:dd38:cd89:1e6b',
            'dc5a:f8de:be0f:3cb3:38ae:70f8:a379:b1f6',
            '82a5:c180:e024:c91b:6e0c:1f46:c773:acdf',
            '5833:d7fc:6a21:2bab:e268:98f6:b381:22f6',
            '66dc:62eb:023f:9a38:d4f7:1100:127b:096d',
            'ec06:c84a:4cd8:295a:df6a:e207:27b7:ce43',
            '592f:cc09:378a:49fd:5b76:7840:2249:4446',
            '993e:4743:e54b:8317:b71b:b0ce:78e7:15eb',
            '4297:5c0f:445b:4772:f639:af3b:6355:590b',
            'bec5:9f55:cfa0:b515:a60b:58e5:4d14:891b',
            'f40e:1c25:9148:c0cd:2489:a6c6:eab6:d1ec',
            '62a8:7fa9:6d5a:fc93:2771:6b4a:b611:7540',
            '82fa:3e67:ffb8:d2db:64b6:7daf:4188:f610',
            '7162:007d:1637:4f61:44ee:a489:8e51:a5f4',
        ];
        
        foreach ($tests as $test) {
            $this->assertSame($test, $this->filter->sanitize($test, [Filter::FILTER_IPV6]));
            $this->assertSame('', $this->filter->sanitize('!' . $test, [Filter::FILTER_IPV6]));
        }
    }
    
    public function testIPv4(): void
    {
        $tests = [
            '136.87.92.155',
            '20.56.162.127',
            '16.145.22.177',
            '188.253.246.132',
            '188.50.122.4',
            '115.239.163.138',
            '38.66.150.34',
            '29.13.175.124',
            '2.197.70.110',
            '187.29.65.173',
            '151.152.159.14',
            '117.78.5.54',
            '239.12.152.16',
            '110.208.72.8',
            '92.76.221.84',
            '79.247.146.1',
            '32.173.90.97',
            '87.58.41.218',
            '117.28.48.227',
            '184.183.78.163',
        ];
        
        foreach ($tests as $test) {
            $this->assertSame($test, $this->filter->sanitize($test, [Filter::FILTER_IPV4]));
            $this->assertSame('', $this->filter->sanitize('!' . $test, [Filter::FILTER_IPV4]));
        }
    }
}
