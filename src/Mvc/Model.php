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

use Phalcon\Config;
use Phalcon\Events\Manager;
use Phalcon\Mvc\Model\Behavior\Timestampable;

use Phalcon\Security;
use Zemit\Mvc\Model\Behavior\Blameable;
use Zemit\Mvc\Model\Behavior\Conditional;
use Zemit\Mvc\Model\Behavior\Position;
use Zemit\Mvc\Model\Behavior\SoftDelete;

use Zemit\Mvc\Model\Behavior\Transformable;
use Zemit\Mvc\Model\Eagerload;
use Zemit\Mvc\Model\Expose\Expose;
use Zemit\Mvc\Model\FindIn;
use Zemit\Mvc\Model\Log;
use Zemit\Mvc\Model\RawValue;
use Zemit\Mvc\Model\Relationship;
use Zemit\Mvc\Model\Slug;
use Zemit\Mvc\Model\Snapshots;
use Zemit\Mvc\Model\User;
//use Zemit\Mvc\Model\Utils;

/**
 * Class
 * Switches default Phalcon MVC into a simple HMVC to allow requests
 * between different namespaces and modules
 *
 * Terminology - Update vs Modify vs Change - Create vs Add - Delete vs Remove
 * You create something from scratch. Like create a new report.
 * Once in existence, you add something to a container. Like adding a person to the managers group.
 * By modifying something you change its properties. Like modifying a design.
 * By updating something you change the data, but not the design. Like updating someone's phone number.
 * By changing something you replace one existing thing with another. Like changing your profile photo.
 * By removing something you take it out of a container. Like removing something from the fridge - the thing still exist.
 * By destroying something you do the opposite from creating - gone forever. Like destroying a toy.
 * By deleting something you wipe if off, so it is no longer retrievable. This is said with the obvious exception
 * that nowadays people are accustomed to the 'undelete' feature. So somewhat of an ambiguity here, but it is a standard
 * in interfaces to use the term for permanent delation.
 * @link https://ux.stackexchange.com/questions/43174/update-vs-modify-vs-change-create-vs-add-delete-vs-remove
 *
 * Events
 * - afterCreate
 * - afterDelete
 * - afterFetch
 * - afterSave
 * - afterUpdate
 * - afterValidation
 * - afterValidationOnCreate
 * - afterValidationOnUpdate
 * - beforeDelete
 * - beforeCreate
 * - beforeSave
 * - beforeUpdate
 * - beforeValidation
 * - beforeValidationOnCreate
 * - beforeValidationOnUpdate
 * - notDeleted
 * - notSaved
 * - onValidationFails
 * - prepareSave
 * - validation
 * @link https://docs.phalcon.io/4.0/en/db-models#events
 *
 * {@inheritdoc} \Phalcon\Mvc\Model
 * @package Zemit\Mvc
 */
class Model extends \Phalcon\Mvc\Model
{
    const DELETED_FIELD = 'deleted';
    const POSITION_FIELD = 'position';
    
    const YES = 1;
    const NO = 0;
    
    const DATETIME_FORMAT = 'Y-m-d H:i:s';
    const DATE_FORMAT = 'Y-m-d';
    
    use \Zemit\Mvc\Model\Eagerload;
    use \Zemit\Mvc\Model\Relationship;
    use \Zemit\Mvc\Model\Expose\Expose;
    use \Zemit\Mvc\Model\FindIn;
    use \Zemit\Mvc\Model\SoftDelete;
//    use \Zemit\Mvc\Model\Utils;
    
    public function initialize()
    {
        // Default model setup
        self::setup();
        $this->setEventsManager(new Manager());
        $this->keepSnapshots(true);
        $this->useDynamicUpdate(true);
        
        // Timestamp Behaviors
        $this->addCreatedAtBehavior();
        $this->addUpdatedAtBehavior();
        $this->addDeletedAtBehavior();
        $this->addRestoredAtBehavior();
        
        // Current User Behaviors
        $this->addCreatedByBehavior();
        $this->addUpdatedByBehavior();
        $this->addDeletedByBehavior();
        $this->addRestoredByBehavior();

        // Other Behaviors
        $this->addSlugBehavior();
        $this->addSoftDeleteBehavior();
        $this->addBlameableBehavior();
        $this->addPositionBehavior();
    }
    
    /**
     * Enables/disables options in the ORM
     * - We do this here in order to keep behaviour consistencies between different environments
     * --------------------------------
     *  caseInsensitiveColumnMap - false - Case insensitive column map
     *  castLastInsertIdToInt - false - Casts the lastInsertId to an integer
     *  castOnHydrate - false - Automatic cast to original types on hydration
     *  columnRenaming - true - Column renaming
     *  disableAssignSetters - false - Disable setters
     *  enableImplicitJoins - true - Enable implicit joins
     *  events - true - Callbacks, hooks and event notifications from all the models
     *  exceptionOnFailedMetaDataSave - false - Throw an exception when there is a failed meta-data save
     *  exceptionOnFailedSave - false - Throw an exception when there is a failed save()
     *  ignoreUnknownColumns - false - Ignore unknown columns on the model
     *  lateStateBinding - false - Late state binding of the Phalcon\Mvc\Model::cloneResultMap() method
     *  notNullValidations - true - Automatically validate the not null columns present
     *  phqlLiterals - true - Literals in the PHQL parser
     *  prefetchRecords - 0 - The number of records to prefetch when getting data from the ORM
     *  updateSnapshotOnSave - true - Update snapshots on save()
     *  virtualForeignKeys - true - Virtual foreign keys
     * --------------------------------
     * @link https://docs.phalcon.io/4.0/en/db-models#model-features
     *
     * @param array|null $options
     */
    public static function setup(array $options = null) : void
    {
        parent::setup(array_merge([
            'caseInsensitiveColumnMap' => false,
            'castLastInsertIdToInt' => true, // changed from default
            'castOnHydrate' => true, // changed from default
            'columnRenaming' => true,
            'disableAssignSetters' => false,
            'enableImplicitJoins' => true,
            'events' => true,
            'exceptionOnFailedMetaDataSave' => false,
            'exceptionOnFailedSave' => false,
            'ignoreUnknownColumns' => false,
            'lateStateBinding' => false,
            'notNullValidations' => false, // changed from default @todo see if we can
            'phqlLiterals' => true,
            'prefetchRecords' => 0,
            'updateSnapshotOnSave' => true,
            'virtualForeignKeys' => true,
        ], $options ?? []));
    }
    
    /**
     * Created At Timestamp
     */
    public function addCreatedAtBehavior() : void {
        $this->addBehavior(new Timestampable([
            'beforeValidationOnCreate' => [
                'field' => 'createdAt',
                'format' => 'Y-m-d H:i:s',
            ],
        ]));
    }
    
    /**
     * Updated At Timestamp
     */
    public function addUpdatedAtBehavior() : void {
        $this->addBehavior(new Timestampable([
            'beforeValidationOnUpdate' => [
                'field' => 'updatedAt',
                'format' => self::DATETIME_FORMAT,
            ],
        ]));
    }
    
    /**
     * Deleted At Timestamp
     */
    public function addDeletedAtBehavior() : void {
        $this->addBehavior(new Timestampable([
            'beforeDelete' => [
                'field' => 'deletedAt',
                'format' => self::DATETIME_FORMAT,
            ],
        ]));
    }
    
    /**
     * Restored At Timestamp
     */
    public function addRestoredAtBehavior() : void {
        $this->addBehavior(new Timestampable([
            'beforeRestore' => [
                'field' => 'restoredAt',
                'format' => self::DATETIME_FORMAT,
            ],
        ]));
    }
    
    /**
     * Created By
     */
    public function addCreatedByBehavior() : void {
        $this->addBehavior(new Transformable([
            'beforeValidationOnCreate' => [
                'createdBy' => $this->getCurrentUser(),
            ],
        ]));
    }
    
    /**
     * Updated By
     */
    public function addUpdatedByBehavior() : void {
        $this->addBehavior(new Transformable([
            'beforeValidationOnUpdate' => [
                'updatedBy' => $this->getCurrentUser(),
            ],
        ]));
    }
    
    /**
     * Deleted By
     */
    public function addDeletedByBehavior() : void {
        $this->addBehavior(new Transformable([
            'beforeDelete' => [
                'deletedBy' => $this->getCurrentUser(),
            ],
        ]));
    }
    
    /**
     * Deleted By
     */
    public function addRestoredByBehavior() : void {
        $this->addBehavior(new Transformable([
            'beforeRestore' => [
                'restoredBy' => $this->getCurrentUser(),
            ],
        ]));
    }
    
    /**
     * Slug
     */
    public function addSlugBehavior() : void {
        $this->addBehavior(new Transformable([
            'beforeValidation' => [
                'index' => function($builder) {
                    $model = $builder->getModel();
                    $value = $builder->getValue();
                    if (!isset($value)) {
                        $value = $model->getLabel() ?? $model->toJson() ?? json_encode($model->toArray() ?? $model);
                    }
                    return \Zemit\Utils\Slug::generate($value);
                },
            ],
        ]));
    }
    
    /**
     * Soft Delete
     */
    public function addSoftDeleteBehavior() : void {
        $this->addBehavior(new SoftDelete([
            'field' => self::DELETED_FIELD,
            'value' => self::YES,
        ]));
    }
    
    /**
     * Blameable Audit User
     */
    public function addBlameableBehavior() : void {
        $this->addBehavior(new Blameable([
            'auditClass' => Audit::class,
            'auditDetailClass' => AuditDetail::class,
            'userClass' => User::class,
        ]));
    }
    
    /**
     * Position
     */
    public function addPositionBehavior() : void {
        $this->addBehavior(new Position([
            'field' => self::POSITION_FIELD,
        ]));
    }
    
    protected function _postSaveRelatedRecords(\Phalcon\Db\Adapter\AdapterInterface $connection, $related): bool
    {
        [$success, $connection, $related] = $this->_prePostSaveRelatedRecords($connection, $related);
        
        return $success ? parent::_postSaveRelatedRecords($connection, $related) : false;
    }
    
    public function getCurrentUser() {
        return 1;
    }
    
    
    /**
     * Hash method using security salt
     *
     * @param string|null $string
     *
     * @return string
     */
    public function hash(string $string = null)
    {
        /** @var Config $config */
        $config = $this->getDI()->get('config');
        
        /** @var Security $security */
        $security = $this->getDI()->get('security');
        
        // Get the salt
        $salt = $config->security->salt ?? null;
        
        return $security->hash($salt . $string);
    }
    
    /**
     * @param string $password
     *
     * @return bool If the hash is valid or not
     */
    public function checkHash(string $hash = null, string $string = null)
    {
        if (empty($hash)) {
            return false;
        }
        
        if (empty($string)) {
            return false;
        }
        
        /** @var Config $config */
        $config = $this->getDI()->get('config');
        
        /** @var Security $security */
        $security = $this->getDI()->get('security');
        
        // Get salt
        $salt = $config->security->salt ?? null;
        
        return $security->checkHash($salt . $string, $hash);
    }
    
}
