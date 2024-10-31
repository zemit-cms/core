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

namespace Zemit\Tests\Unit\Filter\Validation\Validator;

use Phalcon\Filter\Validation\AbstractValidator;
use Phalcon\Filter\Validation\ValidationInterface;
use Phalcon\Filter\Validation\ValidatorInterface;
use Zemit\Filter\Validation;
use Zemit\Filter\Validation\Validator\Json;
use Zemit\Tests\Unit\AbstractUnit;

class JsonTest extends AbstractUnit
{
    public ValidatorInterface $json;
    public ValidationInterface $validation;
    
    protected function setUp(): void
    {
        $options = [];
        $this->json = new Json($options);
        $this->validation = new Validation();
    }
    
    public function testInstanceOf(): void
    {
        $this->assertInstanceOf(AbstractValidator::class, $this->json);
        $this->assertInstanceOf(ValidatorInterface::class, $this->json);
    }
    
    public function testValidate(): void
    {
        $this->validation->add('field', $this->json);
        
        $validation = $this->validation->validate(['field' => null]);
        $this->assertCount(1, $validation);
        $this->assertEquals('field', $validation->current()->getField());
        
        $this->assertFalse($this->json->validate($this->validation, 'field'));
        $this->assertCount(2, $this->validation->getMessages());
        
        $validation = $this->validation->validate(['field' => json_encode('test')]);
        $this->assertCount(0, $validation);
        
        $this->assertTrue($this->json->validate($this->validation, 'field'));
        $this->assertCount(0, $this->validation->getMessages());
        
        // @todo add more json validations
    }
}
