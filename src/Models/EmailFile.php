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

use Zemit\Models\Base\AbstractEmailFile;
use Phalcon\Filter\Validation\Validator\PresenceOf;

/**
 * Class EmailFile
 *
 * @property Email $EmailEntity
 * @property File $FileEntity
 *
 * @method Email getEmailEntity($params = null)
 * @method File getFileEntity($params = null)
 *
 * @package Zemit\Models
 */
class EmailFile extends AbstractEmailFile
{
    protected $deleted = self::NO;
    protected $position = self::NO;

    public function initialize()
    {
        parent::initialize();

        $this->hasOne('emailId', Email::class, 'id', ['alias' => 'EmailEntity']);
        $this->hasOne('fileId', File::class, 'id', ['alias' => 'FileEntity']);
    }

    public function validation()
    {
        $validator = $this->genericValidation();
        $validator->add('emailId', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('fileId', new PresenceOf(['message' => $this->_('required')]));

        return $this->validate($validator);
    }
}
