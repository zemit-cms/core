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
use \Zemit\Models\AbstractModel;

use Zemit\Models\Abstracts\Interfaces\PhalconMigrationsAbstractInterface;

/**
 * Class PhalconMigrationsAbstract
 *
 * This class defines a PhalconMigrations abstract model that extends the AbstractModel class and implements the PhalconMigrationsAbstractInterface.
 * It provides properties and methods for managing PhalconMigrations data.
 * 
 * 
 */
abstract class PhalconMigrationsAbstract extends \Zemit\Models\AbstractModel implements PhalconMigrationsAbstractInterface
{
    /**
     * Column: version
     * Attributes: First | Primary | NotNull | Size(255) | Type(2)
     * @var mixed
     */
    public mixed $version = null;
        
    /**
     * Column: start_time
     * Attributes: NotNull | Type(17)
     * @var mixed
     */
    public mixed $startTime = 0;
        
    /**
     * Column: end_time
     * Attributes: NotNull | Type(17)
     * @var mixed
     */
    public mixed $endTime = 0;
    
    /**
     * Returns the value of field version
     * Column: version
     * Attributes: First | Primary | NotNull | Size(255) | Type(2)
     * @return mixed
     */
    public function getVersion(): mixed
    {
        return $this->version;
    }
    
    /**
     * Sets the value of field version
     * Column: version 
     * Attributes: First | Primary | NotNull | Size(255) | Type(2)
     * @param mixed $version
     * @return void
     */
    public function setVersion(mixed $version): void
    {
        $this->version = $version;
    }
    
    /**
     * Returns the value of field startTime
     * Column: start_time
     * Attributes: NotNull | Type(17)
     * @return mixed
     */
    public function getStartTime(): mixed
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
    public function setStartTime(mixed $startTime): void
    {
        $this->startTime = $startTime;
    }
    
    /**
     * Returns the value of field endTime
     * Column: end_time
     * Attributes: NotNull | Type(17)
     * @return mixed
     */
    public function getEndTime(): mixed
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
    public function setEndTime(mixed $endTime): void
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
    
        $this->addStringLengthValidation($validator, 'version', 0, 255, false);
        
        return $validator;
    }

        
    /**
     * Returns an array that maps the column names of the database
     * table to the corresponding property names of the model.
     * 
     * @returns array The array mapping the column names to the property names
     */
    public function columnMap(): array
    {
        return [
            'version' => 'version',
            'start_time' => 'startTime',
            'end_time' => 'endTime',
        ];
    }
}
