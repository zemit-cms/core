<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Filter\Validation\Validator;

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\AbstractValidator;
use Phalcon\Filter\Validation\ValidatorInterface;

class Json extends AbstractValidator implements ValidatorInterface
{
    protected $template = 'Field :field must be a valid json format';
    
    /**
     * @param array $options = [
     *     'message' => '',
     *     'template' => '',
     *     'depth' => 512,
     *     'flags' => 0,
     *     'allowEmpty' => false
     * ]
     */
    public function __construct(array $options = [])
    {
        parent::__construct($options);
    }
    
    #[\Override]
    public function validate(Validation $validation, $field): bool
    {
        $value = $validation->getValue($field);
        
        $allowEmpty = $this->getOption('allowEmpty', false);
        
        if ($allowEmpty && empty($value)) {
            return true;
        }
        
        $depth = $this->getOption('depth', 512);
        $flags = $this->getOption('flags', 0);
        
        if (!is_string($value) || !json_validate($value, $depth, $flags)) {
            
            $validation->appendMessage(
                $this->messageFactory($validation, $field)
            );
            
            return false;
        }
        
        return true;
    }
}
