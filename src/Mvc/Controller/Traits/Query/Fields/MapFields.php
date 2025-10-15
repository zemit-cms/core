<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Traits\Query\Fields;

use Phalcon\Support\Collection;

trait MapFields
{
    protected ?Collection $mapFields;
    
    /**
     * Initializes the map fields.
     *
     * This method is responsible for initializing the necessary map fields for the model
     *
     * @return void
     */
    public function initializeMapFields(): void
    {
        $this->setMapFields(null);
    }
    
    /**
     * Sets the fields for mapping data.
     *
     * @param Collection|null $mapFields The array of map fields.
     *                                   Pass null to disable the mappings.
     */
    public function setMapFields(?Collection $mapFields): void
    {
        $this->mapFields = $mapFields;
    }
    
    /**
     * Returns the map fields.
     *
     * This method retrieves the map fields for the model.
     * If map fields have been set, it returns the collection of map fields.
     * If no map fields have been set, it returns null.
     *
     * Note: The map fields are the fields that are mapped during the data assignation (save).
     *
     * @return Collection|null The collection of map fields or null if no map fields have been set.
     */
    public function getMapFields(): ?Collection
    {
        return $this->mapFields;
    }

    /**
     * Determines if map fields are set.
     *
     * This method checks whether the map fields have been initialized and are not null.
     *
     * @return bool True if map fields are set, otherwise false.
     */
    public function hasMapFields(): bool
    {
        return $this->mapFields !== null;
    }
}
