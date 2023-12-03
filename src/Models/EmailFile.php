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

use Zemit\Models\Abstracts\AbstractEmailFile;
use Phalcon\Filter\Validation\Validator\PresenceOf;
use Zemit\Models\Interfaces\EmailFileInterface;

/**
 * @property Email $EmailEntity
 * @property File $FileEntity
 *
 * @method Email getEmailEntity(?array $params = null)
 * @method File getFileEntity(?array $params = null)
 */
class EmailFile extends AbstractEmailFile implements EmailFileInterface
{
    protected $deleted = self::NO;

    public function initialize(): void
    {
        parent::initialize();

        $this->hasOne('emailId', Email::class, 'id', ['alias' => 'EmailEntity']);
        $this->hasOne('fileId', File::class, 'id', ['alias' => 'FileEntity']);
    }

    public function validation(): bool
    {
        $validator = $this->genericValidation();
        $validator->add('emailId', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('fileId', new PresenceOf(['message' => $this->_('required')]));

        return $this->validate($validator);
    }
}
