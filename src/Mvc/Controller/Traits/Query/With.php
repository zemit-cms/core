<?php

declare(strict_types=1);

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
use Zemit\Mvc\Controller\Traits\Abstracts\Query\AbstractWith;

trait With
{
    use AbstractWith;
    
    protected ?Collection $with = null;
    
    /**
     * Initializes the relationships.
     *
     * This method is responsible for initializing the allowed relationship aliases.
     *
     * @return void
     */
    public function initializeWith(): void
    {
        $this->setWith(null);
    }
    
    /**
     * Sets the allowed relationship aliases.
     *
     * @param Collection|null $with The collection of relationship aliases.
     *                              Pass null to allow any relationships.
     */
    public function setWith(?Collection $with): void
    {
        $this->with = $with;
    }
    
    /**
     * Returns the relationship aliases collection.
     *
     * This method retrieves the allowed relationship aliases for the model.
     * If with fields have been set, it returns the collection of relationship aliases.
     * If no relationship aliases have been set, it returns null.
     *
     * Note: The relationship aliases are the fields that are allowed to retrieve during queries.
     *
     * @return Collection|null The collection of relationship aliases or null everything is allowed.
     */
    public function getWith(): ?Collection
    {
        return $this->with;
    }
}
