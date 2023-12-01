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

use Zemit\Models\Abstracts\AbstractSiteLang;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Uniqueness;
use Zemit\Models\Interfaces\SiteLangInterface;

/**
 * @property Site $Site
 * @property Lang $Lang
 * @property Site $SiteEntity
 * @property Lang $LangEntity
 *
 * @method Site getSite(?array $params = null)
 * @method Lang getLang(?array $params = null)
 * @method Site getSiteEntity(?array $params = null)
 * @method Lang getLangEntity(?array $params = null)
 */
class SiteLang extends AbstractSiteLang implements SiteLangInterface
{
    protected $deleted = self::NO;

    public function initialize(): void
    {
        parent::initialize();

        $this->hasOne('siteId', Site::class, 'id', ['alias' => 'SiteEntity']);
        $this->hasOne('langId', Lang::class, 'id', ['alias' => 'LangEntity']);
    }

    public function validation(): bool
    {
        $validator = $this->genericValidation();

        $validator->add('siteId', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('langId', new PresenceOf(['message' => $this->_('required')]));
        $validator->add(['siteId', 'langId'], new Uniqueness(['message' => $this->_('not-unique')]));

        return $this->validate($validator);
    }
}
