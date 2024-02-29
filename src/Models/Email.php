<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Models;

use Zemit\Db\Column;
use Zemit\Models\Abstracts\AbstractEmail;
use Phalcon\Incubator\Mailer\Manager;
use Phalcon\Messages\Message;
use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Filter\Validation\Validator\StringLength\Max;
use Phalcon\Filter\Validation\Validator\Uniqueness;
use Phalcon\Filter\Validation\Validator\Numericality;
use Zemit\Models\Interfaces\EmailInterface;

/**
 * @property Template $TemplateEntity
 * @method Template getTemplateEntity(?array $params = null)
 * 
 * @property EmailFile $FileNode
 * @method EmailFile getFileNode(?array $params = null)
 * 
 * @property File $FileList
 * @method File getFileList(?array $params = null)
 */
class Email extends AbstractEmail implements EmailInterface
{
    protected $deleted = self::NO;
    protected $sent = self::NO;
    
    public function initialize(): void
    {
        parent::initialize();
        // @todo relationships
    }
    
    public function validation(): bool
    {
        $validator = $this->genericValidation();
        
        // @todo validations
        
        return $this->validate($validator);
    }
}
