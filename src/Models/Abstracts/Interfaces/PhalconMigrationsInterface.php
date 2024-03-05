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

use Zemit\Mvc\ModelInterface;

interface PhalconMigrationsInterface extends ModelInterface
{
/**
     * Returns the value of field id
     * Column: id
     * @return ?int
     */
    public function getId(): ?int;
    
    /**
     * Sets the value of field id
     * Column: id 
     * @param ?int $id
     * @return void
     */
    public function setId(?int $id): void;
    
    /**
     * Returns the value of field version
     * Column: version
     * @return string
     */
    public function getVersion(): string;
    
    /**
     * Sets the value of field version
     * Column: version 
     * @param string $version
     * @return void
     */
    public function setVersion(string $version): void;
    
    /**
     * Returns the value of field startTime
     * Column: start_time
     * @return int
     */
    public function getStartTime(): int;
    
    /**
     * Sets the value of field startTime
     * Column: start_time 
     * @param int $startTime
     * @return void
     */
    public function setStartTime(int $startTime): void;
    
    /**
     * Returns the value of field endTime
     * Column: end_time
     * @return int
     */
    public function getEndTime(): int;
    
    /**
     * Sets the value of field endTime
     * Column: end_time 
     * @param int $endTime
     * @return void
     */
    public function setEndTime(int $endTime): void;
}