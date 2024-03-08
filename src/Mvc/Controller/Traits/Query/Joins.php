<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed joins this source code.
 */

namespace Zemit\Mvc\Controller\Traits\Query;

use Phalcon\Support\Collection;

trait Joins
{
    protected ?Collection $joins;
    
    /**
     * Initializes the joins.
     *
     * This method is responsible for initializing the joins.
     *
     * @return void
     */
    public function initializeJoins(): void
    {
        $this->setJoins(null);
    }
    
    /**
     * Sets the joins for the find criteria.
     *
     * @param Collection|null $joins The collection of joins.
     *                               Pass null to disable joins.
     */
    public function setJoins(?Collection $joins): void
    {
        $this->joins = $joins;
    }
    
    /**
     * Returns the joins collection.
     *
     * This method retrieves the joins for the find criteria.
     * If joins fields have been set, it returns the collection of joins.
     * If no joins have been set, it returns null.
     *
     * Note: The joins are used to add conditions during the find query and are not added to the result.
     *
     * @return Collection|null The collection of joins or null everything is allowed.
     */
    public function getJoins(): ?Collection
    {
        return $this->joins;
    }
    
}
