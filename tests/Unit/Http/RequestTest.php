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

namespace Zemit\Tests\Unit\Http;

use Zemit\Http\Request;
use Zemit\Http\RequestInterface;
use Zemit\Tests\Unit\AbstractUnit;

class RequestTest extends AbstractUnit
{
    public RequestInterface $request;
    public array $serverStorage;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->request = $this->di->get('request');
    }
    
    public function testRequestFromDi(): void
    {
        $this->assertInstanceOf(Request::class, $this->request);
    }
    
    /**
     * Testing the bootstrap service
     */
    public function testToArray(): void
    {
        $request = new Request();
        $expectedResult = [
            'body' => '',
            'post' => [],
            'get' => [],
            'put' => [],
            'headers' => [],
            'userAgent' => '',
            'basicAuth' => null,
            'bestAccept' => '',
            'bestCharset' => '',
            'bestLanguage' => '',
            'clientAddress' => false,
            'clientCharsets' => [],
            'contentType' => null,
            'digestAuth' => [],
            'httpHost' => '',
            'uri' => '',
            'serverName' => 'localhost',
            'serverAddress' => '127.0.0.1',
            'method' => 'GET',
            'port' => 0,
            'httpReferer' => '',
            'languages' => [],
            'scheme' => 'http',
            'isAjax' => false,
            'isGet' => true,
            'isDelete' => false,
            'isHead' => false,
            'isPatch' => false,
            'isConnect' => false,
            'isTrace' => false,
            'isPut' => false,
            'isPurge' => false,
            'isOptions' => false,
            'isSoap' => false,
            'isSecure' => false,
            'isCors' => false,
            'isPreflight' => false,
            'isSameOrigin' => false,
            'isValidHttpMethod' => true,
        ];
        
        $result = $request->toArray();
        $this->assertEquals($expectedResult, $result);
    }
    
    public function testIsCors(): void
    {
        $this->assertFalse($this->request->isCors());
        
        $this->setServerValues('https://cors-origin');
        $this->assertTrue($this->request->isCors());
        $this->unsetServerValues();
    }
    
    public function testIsPreflight(): void
    {
        $this->assertFalse($this->request->isPreflight());
        
        $this->setServerValues('https://prefligh-origin');
        $this->assertTrue($this->request->isPreflight());
        $this->unsetServerValues();
    }
    
    public function testIsSameOrigin(): void
    {
        $this->assertFalse($this->request->isSameOrigin());
        
        $this->setServerValues();
        $this->assertTrue($this->request->isSameOrigin());
        $this->unsetServerValues();
    }
    
    public function setServerValues(string $origin = 'https://localhost'): void
    {
        $this->serverStorage = $_SERVER;
        $_SERVER['REQUEST_METHOD'] = 'options';
        $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] = 'GET';
        $_SERVER["ORIGIN"] = $origin;
        $_SERVER["HTTP_HOST"] = 'localhost';
        $_SERVER["HTTPS"] = 'on';
    }
    
    public function unsetServerValues(): void
    {
        $_SERVER = $this->serverStorage;
    }
}
