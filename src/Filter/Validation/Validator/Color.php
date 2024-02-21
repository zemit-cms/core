<?php

namespace Zemit\Filter\Validation\Validator;

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\AbstractValidator;
use Phalcon\Filter\Validation\ValidatorInterface;

class Color extends AbstractValidator implements ValidatorInterface
{
    protected $template = 'Field :field must be a valid color in hexadecimal format (e.g., #RRGGBB)';
    
    /**
     * @param array $options = [
     *     'message' => '',
     *     'template' => '',
     *     'allowEmpty' => false
     * ]
     */
    public function __construct(array $options = [])
    {
        parent::__construct($options);
    }
    
    public function validate(Validation $validation, $field): bool
    {
        $value = $validation->getValue($field);
        
        if (!is_string($value) || !$this->isValidColor($value)) {
            
            $validation->appendMessage(
                $this->messageFactory($validation, $field)
            );
            
            return false;
        }
        
        return true;
    }
    
    /**
     * Check if a given color is in a valid hexadecimal format.
     */
    private function isValidColor(string $color): bool
    {
        // Hexadecimal color regex pattern (supports 3, 4, 6, or 8 digits)
        $pattern = '/^#([A-Fa-f0-9]{3,4}|[A-Fa-f0-9]{6}|[A-Fa-f0-9]{8})$/';
        
        return preg_match($pattern, $color) === 1;
    }
}
