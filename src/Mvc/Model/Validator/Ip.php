<?php

namespace Zemit\Core\Validation\Validator;

use Phalcon\Validation\Validator;
use Phalcon\Validation\ValidatorInterface;
use Phalcon\Validation\Message;

class Ip extends Validator implements ValidatorInterface {

    /**
     * Executes the validation
     *
     * @param Phalcon\Validation $validator
     * @param string $attribute
     * @return boolean
     */
    public function validate(\Phalcon\Validation $validator, $attribute) {
        $value = $validator->getValue($attribute);
        
        // @TODO add support to use ipv6 or ipv4 flags
//        $ipv6 = (bool) $this->getOption('ipv6');
//        $ipv4 = (bool) $this->getOption('ipv6');

        if (!filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6)) {

            $message = $this->getOption('message');
            if (!$message) {
                $message = 'The IP is not valid';
            }

            $validator->appendMessage(new Message($message, $attribute, 'Ip'));

            return false;
        }

        return true;
    }

}
