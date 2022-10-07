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

use Zemit\Models\Base\AbstractSiteLang;
use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Filter\Validation\Validator\Uniqueness;

/**
 * Class SiteLang
 *
 * @property Site $Site
 * @property Lang $Lang
 * @property Site $SiteEntity
 * @property Lang $LangEntity
 *
 * @method Site getSite($params = null)
 * @method Lang getLang($params = null)
 * @method Site getSiteEntity($params = null)
 * @method Lang getLangEntity($params = null)
 *
 * @package Zemit\Models
 */
class SiteLang extends AbstractSiteLang
{
    protected $deleted = self::NO;

    public function initialize()
    {
        parent::initialize();

        $this->hasOne('siteId', Site::class, 'id', ['alias' => 'SiteEntity']);
        $this->hasOne('langId', Lang::class, 'id', ['alias' => 'LangEntity']);
    }

    public function validation()
    {
        $validator = $this->genericValidation();

        $validator->add('siteId', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('langId', new PresenceOf(['message' => $this->_('required')]));
        $validator->add(['siteId', 'langId'], new Uniqueness(['message' => $this->_('not-unique')]));

        return $this->validate($validator);
    }
}
