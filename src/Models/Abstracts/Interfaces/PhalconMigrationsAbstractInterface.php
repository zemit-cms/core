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

namespace Zemit\Models\Abstracts\Interfaces;

use Phalcon\Db\RawValue;
use Zemit\Mvc\ModelInterface;

interface PhalconMigrationsAbstractInterface extends ModelInterface
{
    /**
     * Returns the value of field id
     * Column: id
     * Attributes: First | NotNull | Numeric | Unsigned | AutoIncrement
     * @return mixed
     */
    public function getId();
    
    /**
     * Sets the value of field id
     * Column: id 
     * Attributes: First | NotNull | Numeric | Unsigned | AutoIncrement
     * @param mixed $id
     * @return void
     */
    public function setId($id);
    
    /**
     * Returns the value of field version
     * Column: version
     * Attributes: Primary | NotNull | Size(255) | Type(2)
     * @return mixed
     */
    public function getVersion();
    
    /**
     * Sets the value of field version
     * Column: version 
     * Attributes: Primary | NotNull | Size(255) | Type(2)
     * @param mixed $version
     * @return void
     */
    public function setVersion($version);
    
    /**
     * Returns the value of field startTime
     * Column: start_time
     * Attributes: NotNull | Type(17)
     * @return mixed
     */
    public function getStartTime();
    
    /**
     * Sets the value of field startTime
     * Column: start_time 
     * Attributes: NotNull | Type(17)
     * @param mixed $startTime
     * @return void
     */
    public function setStartTime($startTime);
    
    /**
     * Returns the value of field endTime
     * Column: end_time
     * Attributes: NotNull | Type(17)
     * @return mixed
     */
    public function getEndTime();
    
    /**
     * Sets the value of field endTime
     * Column: end_time 
     * Attributes: NotNull | Type(17)
     * @param mixed $endTime
     * @return void
     */
    public function setEndTime($endTime);
}