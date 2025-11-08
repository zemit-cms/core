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

namespace PhalconKit\Tests\Unit\Filter\Validation\Validator;

use Phalcon\Filter\Validation\AbstractValidator;
use Phalcon\Filter\Validation\ValidationInterface;
use Phalcon\Filter\Validation\ValidatorInterface;
use PhalconKit\Filter\Validation;
use PhalconKit\Filter\Validation\Validator\Color;
use PhalconKit\Tests\Unit\AbstractUnit;

class ColorTest extends AbstractUnit
{
    public ValidatorInterface $color;
    public ValidationInterface $validation;
    
    protected function setUp(): void
    {
        $options = [];
        $this->color = new Color($options);
        $this->validation = new Validation();
    }
    
    public function testInstanceOf(): void
    {
        $this->assertInstanceOf(AbstractValidator::class, $this->color);
        $this->assertInstanceOf(ValidatorInterface::class, $this->color);
    }
    
    public function testValidate(): void
    {
        $this->validation->add('field', $this->color);
        
        $validation = $this->validation->validate(['field' => null]);
        $this->assertCount(1, $validation);
        $this->assertEquals('field', $validation->current()->getField());
        
        $this->assertFalse($this->color->validate($this->validation, 'field'));
        $this->assertCount(2, $this->validation->getMessages());
        
        $validation = $this->validation->validate(['field' => '#000000']);
        $this->assertCount(0, $validation);
        
        $this->assertTrue($this->color->validate($this->validation, 'field'));
        $this->assertCount(0, $this->validation->getMessages());
        
        // @todo add more color validations
    }
}
