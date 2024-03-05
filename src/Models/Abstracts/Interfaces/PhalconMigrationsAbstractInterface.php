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
     * @return RawValue|int|null
     */
    public function getId(): RawValue|int|null;
    
    /**
     * Sets the value of field id
     * Column: id 
     * @param RawValue|int|null $id
     * @return void
     */
    public function setId(RawValue|int|null $id): void;
    
    /**
     * Returns the value of field version
     * Column: version
     * @return RawValue|string|null
     */
    public function getVersion(): RawValue|string|null;
    
    /**
     * Sets the value of field version
     * Column: version 
     * @param RawValue|string|null $version
     * @return void
     */
    public function setVersion(RawValue|string|null $version): void;
    
    /**
     * Returns the value of field startTime
     * Column: start_time
     * @return RawValue|int
     */
    public function getStartTime(): RawValue|int;
    
    /**
     * Sets the value of field startTime
     * Column: start_time 
     * @param RawValue|int $startTime
     * @return void
     */
    public function setStartTime(RawValue|int $startTime): void;
    
    /**
     * Returns the value of field endTime
     * Column: end_time
     * @return RawValue|int
     */
    public function getEndTime(): RawValue|int;
    
    /**
     * Sets the value of field endTime
     * Column: end_time 
     * @param RawValue|int $endTime
     * @return void
     */
    public function setEndTime(RawValue|int $endTime): void;
}