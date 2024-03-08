<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Traits\Query;

use Phalcon\Support\Collection;

trait Bind
{
    protected ?Collection $bind;
    protected ?Collection $bindTypes;
    
    /**
     * Initializes the bindings.
     *
     * This method is responsible for initializing the necessary binding data for the queries.
     *
     * @return void
     */
    public function initializeBind(): void
    {
        $this->setBind(null);
    }
    
    /**
     * Initializes the binding types.
     *
     * This method is responsible for initializing the necessary bind types for the queries.
     *
     * @return void
     */
    public function initializeBindTypes(): void
    {
        $this->setBindTypes(null);
    }
    
    /**
     * Sets the fields for binding data.
     *
     * @param Collection|null $bind The collection of field bindings.
     *                              Pass null to disable the field bindings.
     */
    public function setBind(?Collection $bind): void
    {
        $this->bind = $bind;
    }
    
    /**
     * Returns the bind data.
     *
     * This method retrieves the bind fields for the model.
     * If bind fields have been set, it returns the collection of bind fields.
     * If no bind fields have been set, it returns null.
     *
     * Note: The bind fields are the fields that are allowed to be used within database queries.
     *
     * @return Collection|null The collection of bindings or null if binding is disabled.
     */
    public function getBind(): ?Collection
    {
        return $this->bind;
    }
    
    /**
     * Sets the fields for binding data.
     *
     * @param Collection|null $bindTypes The collection of binding types.
     *                                   Pass null to disable the binding types.
     */
    public function setBindTypes(?Collection $bindTypes): void
    {
        $this->bindTypes = $bindTypes;
    }
    
    /**
     * Returns the binding types.
     *
     * This method retrieves the binding types for the query.
     * If bind binding types have been set, it returns the collection of binding types.
     * If no binding types have been set, it returns null.
     *
     * Note: The binding types are the types for the fields used within database queries.
     *
     * @return Collection|null The collection of bindings or null if binding types is disabled.
     */
    public function getBindTypes(): ?Collection
    {
        return $this->bindTypes;
    }
}
