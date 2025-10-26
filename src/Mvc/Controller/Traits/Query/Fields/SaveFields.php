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

trait SaveFields
{
    protected ?Collection $saveFields = null;
    
    /**
     * Initializes the save fields.
     *
     * This method is responsible for initializing the necessary save fields for the model
     *
     * @return void
     */
    public function initializeSaveFields(): void
    {
        $this->setSaveFields(null);
    }
    
    /**
     * Sets the fields for saving data.
     *
     * @param Collection|null $saveFields The array of save fields.
     *                                    Pass null to allow saving all fields.
     */
    public function setSaveFields(?Collection $saveFields): void
    {
        $this->saveFields = $saveFields;
    }
    
    /**
     * Returns the save fields.
     *
     * This method retrieves the save fields for the model.
     * If save fields have been set, it returns the collection of save fields.
     * If no save fields have been set, it returns null.
     *
     * Note: The save fields are the fields that are allowed to be saved in the database for the model.
     *
     * @return Collection|null The collection of save fields or null if no save fields have been set.
     */
    public function getSaveFields(): ?Collection
    {
        return $this->saveFields;
    }

    /**
     * Checks if the save fields are set.
     *
     * This method determines whether the save fields have been initialized.
     *
     * @return bool True if save fields are set, otherwise false.
     */
    public function hasSaveFields(): bool
    {
        return $this->saveFields !== null;
    }
}
