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

use Phalcon\Messages\Message;
use Phalcon\Validation;
use Zemit\Validation\AbstractValidator;

class Language extends AbstractValidator
{
    /**
     * Executes the language check validation
     *
     * @param Validation $validator
     * @param string $attribute
     *
     * @return boolean
     */
    public function validate(Validation $validator, $attribute): bool
    {
        $languages = $this->config->local->allowed->toArray() ?? ['en'];
        if (in_array($validator->getValue($attribute), $languages, true)) {
            
            $message = $this->getOption('message');
            
            if (!$message) {
                $message = 'The provided language `' . $validator->getValue($attribute) . '` is not supported.';
            }
            
            $validator->appendMessage(new Message($message, $attribute, get_class($this)));
            
            return false;
        }
        
        return true;
    }
}
