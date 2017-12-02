<?php

namespace Zemit\Validation\Validator;

use Phalcon\Validation\Validator;
use Phalcon\Validation\ValidatorInterface;
use Phalcon\Validation\Message;

class Digits extends Validator implements ValidatorInterface {

    /**
     * Executes the validation
     *
     * @param Phalcon\Validation $validator
     * @param string $attribute
     * @return boolean
     */
    public function validate(\Phalcon\Validation $validator, $attribute) {
        $value = $validator->getValue($attribute);

        if (extension_loaded('mbstring')) {
            // Filter for the value with mbstring
            $pattern = '/[^[:digit:]]/';
        } else {
            // Filter for the value without mbstring using generic regex
            $pattern = '/[\p{^N}]/';
        }

        $filtered = preg_replace($pattern, '', (string) $value);

        if ((!is_int($value) && !is_float($value)) || $value !== $filtered) {

            $message = $this->getOption('message');
            if (!$message) {
                $message = 'Value contains non-numeric characters';
            }

            $validator->appendMessage(new Message($message, $attribute, 'Digits'));

            return false;
        }

        return true;
    }

}
