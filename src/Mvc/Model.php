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

use Phalcon\Events\Manager as EventsManager;

/**
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
class Model extends \Phalcon\Mvc\Model implements \Phalcon\Mvc\EntityInterface, \Phalcon\Mvc\ModelInterface, \Phalcon\Mvc\Model\ResultInterface, \Serializable, \JsonSerializable
{
    // Model Feature Traits
    use \Zemit\Mvc\Model\Options;
    use \Zemit\Mvc\Model\Events;
    use \Zemit\Mvc\Model\Security;
    use \Zemit\Mvc\Model\EagerLoad;
    use \Zemit\Mvc\Model\Relationship;
    use \Zemit\Mvc\Model\Expose;
    use \Zemit\Mvc\Model\FindIn;
    use \Zemit\Mvc\Model\SoftDelete;
    use \Zemit\Mvc\Model\Identity;
    use \Zemit\Mvc\Model\Replication;
    use \Zemit\Mvc\Model\Cache;
    use \Zemit\Mvc\Model\Hash;
    use \Zemit\Mvc\Model\Attribute;
    use \Zemit\Mvc\Model\Json;
    use \Zemit\Mvc\Model\Position;
    use \Zemit\Mvc\Model\Blameable;
    use \Zemit\Mvc\Model\FindIn;
    use \Zemit\Mvc\Model\Snapshot;
    use \Zemit\Mvc\Model\LifeCycle;
    use \Zemit\Mvc\Model\PrimaryKeys;
    use \Zemit\Mvc\Model\Options;
    use \Zemit\Mvc\Model\Uuid;
    use \Zemit\Mvc\Model\Slug;
    use \Zemit\Mvc\Model\Validate;
    use \Zemit\Mvc\Model\Locale;
    
    public function initialize(): void
    {
        // Initialize options manager
        $this->initializeOptions();
        
        // Initialize setup & events manager
        self::setup($this->getOptionsManager()->get('setup'));
        $this->setEventsManager(new EventsManager());
        $this->useDynamicUpdate(true);
        
        // Initialize features
        $this->initializeCache();
        $this->initializeSnapshot();
        $this->initializeReplication();
        $this->initializeSoftDelete();
        $this->initializePosition();
        $this->initializeSecurity();
        $this->initializeBlameable();
        $this->initializeCreated();
        $this->initializeUpdated();
        $this->initializeDeleted();
        $this->initializeRestored();
        $this->initializeSlug();
        $this->initializeUuid();
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
    public static function setup(?array $options = null): void
    {
        parent::setup(array_merge([
            'caseInsensitiveColumnMap' => false,
            'castLastInsertIdToInt' => true, // changed from default
//            'castOnHydrate' => true, // changed from default
            'castOnHydrate' => false, // problems with binary when true
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
}
