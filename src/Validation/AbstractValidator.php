<?php

namespace Zemit\Validation;

abstract class AbstractValidator extends \Phalcon\Validation\AbstractValidator
{
    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $this->setOptions($options);
    }
    
    public function setOptions(array $options = [])
    {
        foreach ($options as $key => $option) {
            $this->setOption($key, $option);
        }
    }
}
