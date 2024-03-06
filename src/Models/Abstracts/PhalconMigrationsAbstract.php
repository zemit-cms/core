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
     * Attributes: First | NotNull | Numeric | Unsigned | AutoIncrement
     * @var mixed
     */
    public $id = null;
        
    /**
     * Column: version
     * Attributes: Primary | NotNull | Size(255) | Type(2)
     * @var mixed
     */
    public $version = null;
        
    /**
     * Column: start_time
     * Attributes: NotNull | Type(17)
     * @var mixed
     */
    public $startTime = 0;
        
    /**
     * Column: end_time
     * Attributes: NotNull | Type(17)
     * @var mixed
     */
    public $endTime = 0;
    
    /**
     * Returns the value of field id
     * Column: id
     * Attributes: First | NotNull | Numeric | Unsigned | AutoIncrement
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Sets the value of field id
     * Column: id 
     * Attributes: First | NotNull | Numeric | Unsigned | AutoIncrement
     * @param mixed $id
     * @return void
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * Returns the value of field version
     * Column: version
     * Attributes: Primary | NotNull | Size(255) | Type(2)
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }
    
    /**
     * Sets the value of field version
     * Column: version 
     * Attributes: Primary | NotNull | Size(255) | Type(2)
     * @param mixed $version
     * @return void
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }
    
    /**
     * Returns the value of field startTime
     * Column: start_time
     * Attributes: NotNull | Type(17)
     * @return mixed
     */
    public function getStartTime()
    {
        return $this->startTime;
    }
    
    /**
     * Sets the value of field startTime
     * Column: start_time 
     * Attributes: NotNull | Type(17)
     * @param mixed $startTime
     * @return void
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    }
    
    /**
     * Returns the value of field endTime
     * Column: end_time
     * Attributes: NotNull | Type(17)
     * @return mixed
     */
    public function getEndTime()
    {
        return $this->endTime;
    }
    
    /**
     * Sets the value of field endTime
     * Column: end_time 
     * Attributes: NotNull | Type(17)
     * @param mixed $endTime
     * @return void
     */
    public function setEndTime($endTime)
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
     * @param Validation|null $validator
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