<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Zemit\Models\Abstracts;

use Phalcon\Db\RawValue;
use Zemit\Filter\Validation;
use Zemit\Models\AbstractModel;

use Zemit\Models\Abstracts\Interfaces\PhalconMigrationsAbstractInterface;

/**
 * Class PhalconMigrationsAbstract
 *
 * This class defines a PhalconMigrations abstract model that extends the AbstractModel class and implements the PhalconMigrationsAbstractInterface.
 * It provides properties and methods for managing PhalconMigrations data.
 * 
 * 
 */
abstract class PhalconMigrationsAbstract extends AbstractModel implements PhalconMigrationsAbstractInterface
{
    /**
     * Column: id
     * @var RawValue|int|null
     */
    public RawValue|int|null $id = null;
    
    /**
     * Column: version
     * @var RawValue|string|null
     */
    public RawValue|string|null $version = null;
    
    /**
     * Column: start_time
     * @var RawValue|int
     */
    public RawValue|int $startTime = 0;
    
    /**
     * Column: end_time
     * @var RawValue|int
     */
    public RawValue|int $endTime = 0;
    /**
     * Returns the value of field id
     * Column: id
     * @return RawValue|int|null
     */
    public function getId(): RawValue|int|null
    {
        return $this->id;
    }
    
    /**
     * Sets the value of field id
     * Column: id 
     * @param RawValue|int|null $id
     * @return void
     */
    public function setId(RawValue|int|null $id): void
    {
        $this->id = $id;
    }
    
    /**
     * Returns the value of field version
     * Column: version
     * @return RawValue|string|null
     */
    public function getVersion(): RawValue|string|null
    {
        return $this->version;
    }
    
    /**
     * Sets the value of field version
     * Column: version 
     * @param RawValue|string|null $version
     * @return void
     */
    public function setVersion(RawValue|string|null $version): void
    {
        $this->version = $version;
    }
    
    /**
     * Returns the value of field startTime
     * Column: start_time
     * @return RawValue|int
     */
    public function getStartTime(): RawValue|int
    {
        return $this->startTime;
    }
    
    /**
     * Sets the value of field startTime
     * Column: start_time 
     * @param RawValue|int $startTime
     * @return void
     */
    public function setStartTime(RawValue|int $startTime): void
    {
        $this->startTime = $startTime;
    }
    
    /**
     * Returns the value of field endTime
     * Column: end_time
     * @return RawValue|int
     */
    public function getEndTime(): RawValue|int
    {
        return $this->endTime;
    }
    
    /**
     * Sets the value of field endTime
     * Column: end_time 
     * @param RawValue|int $endTime
     * @return void
     */
    public function setEndTime(RawValue|int $endTime): void
    {
        $this->endTime = $endTime;
    }

    /**
     * Adds the default relationships to the model.
     * @return void
     */
    public function addDefaultRelationships(): void
    {
        // no default relationship found
    }
    
    /**
     * Adds the default validations to the model.
     * @return Validation
     */
    public function addDefaultValidations(?Validation $validator = null): Validation
    {
        $validator ??= new Validation();
    
        $this->addUnsignedIntValidation($validator, 'id', true);
        $this->addStringLengthValidation($validator, 'version', 0, 255, false);
        
        return $validator;
    }

        
    /**
     * Returns an array that maps the column names of the database
     * table to the corresponding property names of the model.
     * 
     * @returns array The array mapping the column names to the property names
     */
    public function columnMap(): array {
        return [
            'id' => 'id',
            'version' => 'version',
            'start_time' => 'startTime',
            'end_time' => 'endTime',
        ];
    }
}