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

use Phalcon\Validation\Validator\InclusionIn;
use Zemit\Models\Base\AbstractSite;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength\Max;

/**
 * Class Site
 *
 * @package Zemit\Models
 */
class Site extends AbstractSite
{
    const STATUS_ACTIVE = 'active';
    const STATUS_MAINTENANCE = 'maintenance';
    const STATUS_SUSPENDED = 'suspended';
    
    protected $deleted = self::NO;
    protected $status = self::STATUS_ACTIVE;
    
    public function initialize()
    {
        parent::initialize();
        
        // Lang relationship
        $this->hasMany('id', SiteLang::class, 'siteId', ['alias' => 'LangNode']);
        $this->hasManyToMany('id', SiteLang::class, 'siteId',
            'langId', Lang::class, 'id', ['alias' => 'LangList']);
    }
    
    public function validation()
    {
        $validator = $this->genericValidation();
        
        $validator->add('name', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('name', new Max(['max' => 255, 'message' => $this->_('length-exceeded')]));
        
        $validator->add('title', new Max(['max' => 255, 'message' => $this->_('length-exceeded')]));
        
        $validator->add('description', new Max(['max' => 255, 'message' => $this->_('length-exceeded')]));
        
        $validator->add('status', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('status', new InclusionIn(['message' => $this->_('not-valid'), 'domain' => [
            self::STATUS_ACTIVE,
            self::STATUS_MAINTENANCE,
            self::STATUS_SUSPENDED,
        ]]));
        
        return $this->validate($validator);
    }
}
