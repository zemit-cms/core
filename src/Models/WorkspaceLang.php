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

use Zemit\Models\Abstracts\AbstractWorkspaceLang;
use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Filter\Validation\Validator\Uniqueness;
use Zemit\Models\Interfaces\WorkspaceLangInterface;

/**
 * @property Workspace $Workspace
 * @property Lang $Lang
 * @property Workspace $WorkspaceEntity
 * @property Lang $LangEntity
 *
 * @method Workspace getWorkspace(?array $params = null)
 * @method Lang getLang(?array $params = null)
 * @method Workspace getWorkspaceEntity(?array $params = null)
 * @method Lang getLangEntity(?array $params = null)
 */
class WorkspaceLang extends AbstractWorkspaceLang implements WorkspaceLangInterface
{
    protected $deleted = self::NO;

    public function initialize(): void
    {
        parent::initialize();

        $this->hasOne('workspaceId', Workspace::class, 'id', ['alias' => 'WorkspaceEntity']);
        $this->hasOne('langId', Lang::class, 'id', ['alias' => 'LangEntity']);
    }

    public function validation(): bool
    {
        $validator = $this->genericValidation();

        $validator->add('workspaceId', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('langId', new PresenceOf(['message' => $this->_('required')]));
        $validator->add(['workspaceId', 'langId'], new Uniqueness(['message' => $this->_('not-unique')]));

        return $this->validate($validator);
    }
}
