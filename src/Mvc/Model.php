<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc;

use Phalcon\Events\Manager;
use Zemit\Mvc\Model\CreatedAt;
use Zemit\Mvc\Model\CreatedBy;
use Zemit\Mvc\Model\DeletedAt;
use Zemit\Mvc\Model\DeletedBy;
use Zemit\Mvc\Model\Eagerload;
use Zemit\Mvc\Model\Expose\Expose;
use Zemit\Mvc\Model\FindIn;
use Zemit\Mvc\Model\RawValue;
use Zemit\Mvc\Model\Relationship;
use Zemit\Mvc\Model\Slug;
use Zemit\Mvc\Model\Snapshots;
use Zemit\Mvc\Model\SoftDelete;
use Zemit\Mvc\Model\UpdatedAt;
use Zemit\Mvc\Model\UpdatedBy;
use Zemit\Mvc\Model\User;
use Zemit\Mvc\Model\Utils;

/**
 * Class
 * Switches default Phalcon MVC into a simple HMVC to allow requests
 * between different namespaces and modules
 * {@inheritdoc} \Phalcon\Mvc\Model
 * @package Zemit\Mvc
 */
class Model extends \Phalcon\Mvc\Model
{
    use RawValue;
    use Eagerload;
    use Expose;
    use FindIn;
    use Utils;
    
    use Slug;
    use User;
    use SoftDelete;
    use CreatedAt;
    use CreatedBy;
    use UpdatedAt;
    use UpdatedBy;
    use DeletedAt;
    use DeletedBy;
    use Relationship;
    use Snapshots;
    
    public function initialize()
    {
        $this->setEventsManager(new Manager());
        
        $this->_setSlug();
        $this->_setUser();
        $this->_setSoftDelete();
        $this->_setCreatedAt();
        $this->_setCreatedBy();
        $this->_setUpdatedAt();
        $this->_setUpdatedBy();
        $this->_setDeletedAt();
        $this->_setDeletedBy();
        $this->_setSnapshots();
    
        $this->useDynamicUpdate(true);
    }
}
