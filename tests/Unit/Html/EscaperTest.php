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

namespace Zemit\Tests\Unit\Html;

use Zemit\Tests\Unit\AbstractUnit;

class EscaperTest extends AbstractUnit
{
    public \Zemit\Html\Escaper\EscaperInterface $escaper;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->escaper = $this->di->get('escaper');
    }
    
    public function testRequestFromDi(): void
    {
        $this->assertInstanceOf(\Phalcon\Html\Escaper::class, $this->escaper);
        $this->assertInstanceOf(\Phalcon\Html\Escaper\EscaperInterface::class, $this->escaper);
        
        $this->assertInstanceOf(\Zemit\Html\Escaper::class, $this->escaper);
        $this->assertInstanceOf(\Zemit\Html\Escaper\EscaperInterface::class, $this->escaper);
    }
    
    /**
     * Test the JSON method on the Escaper class when providing null as input.
     * The method should return 'null' when null is passed as input.
     */
    public function testJsonWithNullString(): void
    {
        $result = $this->escaper->json(json_encode(null));
        $this->assertSame('null', $result);
    }
    
    /**
     * Test the JSON method on the Escaper class when providing null as input.
     * The method should return 'null' when null is passed as input.
     * @todo check if we should return nothing instead
     */
    public function testJsonWithNullType(): void
    {
        $result = $this->escaper->json(null);
        $this->assertSame('null', $result);
    }
    
    /**
     * Test the JSON method on the Escaper class when providing an empty string as input.
     * The method should return the URL-encoded version of an empty JSON string ('""').
     */
    public function testJsonWithEmptyString(): void
    {
        $result = $this->escaper->json('');
        $this->assertSame(rawurlencode('""'), $result);
    }
    
    /**
     * Test the JSON method on the Escaper class when providing an array as input.
     * The method should return raw URL encoded JSON string when an array is passed as input.
     */
    public function testJsonWithArray(): void
    {
        $arrayData = ['data' => 'Some Test Data'];
        $result = $this->escaper->json(json_encode($arrayData));
        
        $this->assertSame(rawurlencode(json_encode($arrayData)), $result);
    }
    
    /**
     * Test the JSON method on the Escaper class when providing an object as input.
     * The method should return raw URL encoded JSON string when an object is passed as input.
     */
    public function testJsonWithObject(): void
    {
        $objectData = new \stdClass();
        $objectData->data = 'Some Test Data';
        $result = $this->escaper->json(json_encode($objectData));
        
        $this->assertSame(rawurlencode(json_encode($objectData)), $result);
    }
}
