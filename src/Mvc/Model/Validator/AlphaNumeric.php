<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Validation\Validator;

use Phalcon\Validation\Validator;
use Phalcon\Validation\ValidatorInterface;
use Phalcon\Validation\Message;

class AlphaNumeric extends Validator implements ValidatorInterface {

    /**
     * Executes the validation
     * Available options:
     *  - allowWhiteSpace => true|false
     * 
     * @param Phalcon\Validation $validator
     * @param string $attribute
     * @return boolean
     */
    public function validate(\Phalcon\Validation $validator, $attribute) {
        $value = $validator->getValue($attribute);
        $allowWhiteSpace = (bool) $this->getOption('allowWhiteSpace');
        $whiteSpace = $allowWhiteSpace ? '\s' : '';

        $pattern = '/[^\p{L}\p{N}' . $whiteSpace . ']/u';
        $filtered = preg_replace($pattern, '', (string) $value);

        if (!is_string($value) || $value !== $filtered) {

            $message = $this->getOption('message');
            if (!$message) {
                $message = 'Value contains non-alpha or numeric characters';
            }

            $validator->appendMessage(new Message($message, $attribute, 'AlphaNumeric'));

            return false;
        }

        return true;
    }

}
