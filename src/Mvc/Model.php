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
 * @link https://docs.phalcon.io/5.6/db-models/#events
 *
 * {@inheritdoc} \Phalcon\Mvc\Model
 * @package Zemit\Mvc
 */
class Model extends \Phalcon\Mvc\Model implements ModelInterface
{
    // Model Feature Traits
    use Model\Traits\Attribute;
    use Model\Traits\Blameable;
    use Model\Traits\Cache;
    use Model\Traits\Count;
    use Model\Traits\EagerLoad;
    use Model\Traits\Events;
    use Model\Traits\Expose;
    use Model\Traits\FindIn;
    use Model\Traits\Hash;
    use Model\Traits\Identity;
    use Model\Traits\Json;
    use Model\Traits\LifeCycle;
    use Model\Traits\Locale;
    use Model\Traits\MetaData;
    use Model\Traits\Options;
    use Model\Traits\Position;
    use Model\Traits\Relationship;
    use Model\Traits\Replication;
    use Model\Traits\Security;
    use Model\Traits\Slug;
    use Model\Traits\Snapshot;
    use Model\Traits\SoftDelete;
    use Model\Traits\Uuid;
    use Model\Traits\Validate;
    
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
            'castOnHydrate' => true, // changed from default
//            'castOnHydrate' => false, // problems with binary when true
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
