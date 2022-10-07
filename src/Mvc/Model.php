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

use Zemit\Bootstrap\Config;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Events\Manager;
use Phalcon\Mvc\Model\Behavior\Timestampable;

use Phalcon\Mvc\ModelInterface;
use Phalcon\Encryption\Security;
use Phalcon\Support\HelperFactory;
use Zemit\Identity;
use Zemit\Models\Audit;
use Zemit\Models\AuditDetail;
use Zemit\Models\Session;
use Zemit\Models\User;
use Zemit\Mvc\Model\Behavior\Blameable;
use Zemit\Mvc\Model\Behavior\Conditional;
use Zemit\Mvc\Model\Behavior\Position;
use Zemit\Mvc\Model\Behavior\SoftDelete;
use Zemit\Mvc\Model\Behavior\Cache;
use Zemit\Mvc\Model\Behavior\Transformable;

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
    const TIME_FORMAT = 'H:i:s';
    const REPLICA_DELAY = 1000;
    
    use \Zemit\Mvc\Model\Eagerload;
    use \Zemit\Mvc\Model\Relationship;
    use \Zemit\Mvc\Model\Expose\Expose;
    use \Zemit\Mvc\Model\FindIn;
    use \Zemit\Mvc\Model\SoftDelete;
    use \Zemit\Mvc\Model\Identity;
    use \Zemit\Mvc\Model\Replication;
    use \Zemit\Mvc\Model\Cache;

//    use \Zemit\Mvc\Model\Events;

//    use \Zemit\Mvc\Model\Utils;
    
    public function initialize()
    {
        // Default model setup
        self::setup();
        
        $this->setEventsManager(new Manager());
        $this->keepSnapshots(true);
        $this->useDynamicUpdate(true);
        
        // Cache
        $this->initializeCache();
        
        // Replication
        $this->initializeReplication();
        
        // Security
        $this->addSecurityBehavior();
        
        // Other Behaviors
        $this->addSlugBehavior();
        $this->addUuidBehavior();
        
        $this->addSoftDeleteBehavior();
        $this->addPositionBehavior();
        $this->addBlameableBehavior();
        
        // Create / Update / Delete / Restore
        $this->addCreatedBehavior();
        $this->addUpdatedBehavior();
        $this->addDeletedBehavior();
        $this->addRestoredBehavior();
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
    public static function setup(array $options = null): void
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
     * Blameable Audit User
     */
    public function addSecurityBehavior(): void
    {
        $config = $this->getDI()->get('config')->identity->toArray();
        $this->addBehavior(new \Zemit\Mvc\Model\Behavior\Security($config));
    }
    
    
    /**
     * Created By
     */
    public function addUuidBehavior(): void
    {
        /** @var \Zemit\Security $security */
        $security = $this->getDI()->get('security');
        
        $this->addBehavior(new Transformable([
            'beforeValidationOnCreate' => [
                'uuid' => function ($model, $field) use ($security) {
                    return $model->getAttribute($field) ?? $security->getRandom()->uuid();
                },
            ],
        ]));
    }
    
    /**
     * Created By
     */
    public function addCreatedBehavior(): void
    {
        $this->addBehavior(new Transformable([
            'beforeValidationOnCreate' => [
                'createdBy' => $this->getCurrentUserIdCallback(false),
                'createdAs' => $this->getCurrentUserIdCallback(true),
                'createdAt' => date(self::DATETIME_FORMAT),
            ],
        ]));
    }
    
    /**
     * Updated By
     */
    public function addUpdatedBehavior(): void
    {
        $this->addBehavior(new Transformable([
            'beforeValidationOnUpdate' => [
                'updatedBy' => $this->hasChangedCallback(function () {
                    return $this->getCurrentUserIdCallback(false)();
                }),
                'updatedAs' => $this->hasChangedCallback(function () {
                    return $this->getCurrentUserIdCallback(true)();
                }),
                'updatedAt' => $this->hasChangedCallback(function () {
                    return date(self::DATETIME_FORMAT);
                }),
            ],
        ]));
    }
    
    /**
     * Deleted By
     */
    public function addDeletedBehavior(): void
    {
        $this->addBehavior(new Transformable([
            'beforeDelete' => [
                'deletedBy' => $this->getCurrentUserIdCallback(false),
                'deletedAs' => $this->getCurrentUserIdCallback(true),
                'deletedAt' => date(self::DATETIME_FORMAT),
            ],
            'beforeValidationOnUpdate' => [
                'deletedBy' => $this->hasChangedCallback(function ($model, $field) {
                    return ($model->isDeleted())
                        ? $this->getCurrentUserIdCallback(false)()
                        : $model->readAttribute($field);
                }),
                'deletedAs' => $this->hasChangedCallback(function ($model, $field) {
                    return ($model->isDeleted())
                        ? $this->getCurrentUserIdCallback(true)()
                        : $model->readAttribute($field);
                }),
                'deletedAt' => $this->hasChangedCallback(function ($model, $field) {
                    return ($model->isDeleted())
                        ? date(self::DATETIME_FORMAT)
                        : $model->readAttribute($field);
                })
//                'deletedAt' => function(ModelInterface $model, string $field) {
//                    return (($model->isDeleted()) && (!$model->hasSnapshotData() || ($model->hasChanged($field) || $model->hasUpdated($field))))
//                        ? date(self::DATETIME_FORMAT)
//                        : $model->readAttribute($field);
//                },
            ],
        ]));
    }
    
    /**
     * Deleted By
     */
    public function addRestoredBehavior(): void
    {
        $this->addBehavior(new Transformable([
            'beforeRestore' => [
                'restoredBy' => $this->getCurrentUserIdCallback(false),
                'restoredAs' => $this->getCurrentUserIdCallback(true),
                'restoredAt' => date(self::DATETIME_FORMAT),
            ],
        ]));
    }
    
    /**
     * Slug
     */
    public function addSlugBehavior(): void
    {
        $this->addBehavior(new Transformable([
            'beforeValidation' => [
                'index' => function ($model, $field) {
                    $value = $model->readAttribute($field);
                    
                    return \Zemit\Utils\Slug::generate($value);
                },
            ],
        ]));
    }
    
    /**
     * Soft Delete
     */
    public function addSoftDeleteBehavior(): void
    {
        $this->addBehavior(new SoftDelete([
            'field' => self::DELETED_FIELD,
            'value' => self::YES,
        ]));
    }
    
    /**
     * Position
     */
    public function addPositionBehavior(): void
    {
        $this->addBehavior(new Position([
            'field' => self::POSITION_FIELD,
        ]));
    }
    
    /**
     * Blameable Audit User
     */
    public function addBlameableBehavior(): void
    {
        /** @var Config $config */
        $config = $this->getDI()->get('config');
        $this->addBehavior(new Blameable([
            'auditClass' => $config->getModelClass(Audit::class),
            'auditDetailClass' => $config->getModelClass(AuditDetail::class),
            'userClass' => $config->getModelClass(User::class),
        ]));
    }
    
    /**
     * Check if the model has changed and return null otherwise
     *
     * @param $callback
     *
     * @return \Closure
     */
    public function hasChangedCallback($callback, $anyField = true)
    {
        return function (ModelInterface $model, $field) use ($callback, $anyField) {
            return (!$model->hasSnapshotData() || $model->hasChanged($anyField ? null : $field) || $model->hasUpdated($anyField ? null : $field)) ?
                $callback($model, $field) :
                $model->readAttribute($field);
        };
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
    public function checkHash(string $hash = null, string $string = null): bool
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
    
    /**
     * Check whether the current entity has dirty related or not
     *
     * @return bool
     */
    public function hasDirtyRelated(): bool
    {
        return count($this->dirtyRelated) ? true : false;
    }
    
    /**
     * Method to get attribute from getters or the raw property, or the read attribute
     *
     * @param string $attribute
     *
     * @return mixed|null
     */
    public function getAttribute(string $attribute)
    {
        if ($this->getModelsMetaData()->hasAttribute($this, $attribute)) {
            $method = 'get' . ucfirst((new HelperFactory)->camelize($attribute));
            if (method_exists($this, $method)) {
                return $this->$method();
            }
            
            if (property_exists($this, $attribute)) {
                return $this->$attribute;
            }
            
            return $this->readAttribute($attribute);
        }
        
        return null;
    }
    
    /**
     * JSON Encode or fallback to value
     * @param mixed $value
     * @param int $flags
     * @param int $depth
     * @return false|string|mixed
     */
    public function jsonEncode(mixed $value, int $flags = JSON_UNESCAPED_SLASHES, int $depth = 512)
    {
        return json_encode($value, $flags, $depth) ?: $value;
    }
    
    /**
     * JSON Decode or fallback to value
     * @param string $json
     * @param bool|null $associative
     * @param int $depth
     * @param int $flags
     * @return mixed|string
     */
    public function jsonDecode(string $json, ?bool $associative = null, int $depth = 512, int $flags = 0)
    {
        return json_decode($json, $associative, $depth, $flags) ?: $json;
    }
}
