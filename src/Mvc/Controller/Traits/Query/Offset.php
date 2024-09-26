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

use Phalcon\Filter\Exception;
use Phalcon\Filter\Filter;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractParams;
use Zemit\Mvc\Controller\Traits\Abstracts\Query\AbstractOffset;

/**
 * This trait provides functionality to set and get an offset value for a query.
 */
trait Offset
{
    use AbstractOffset;
    
    use AbstractParams;
    
    protected ?int $offset = 0;
    
    /**
     * Initializes the offset value.
     *
     * Sets the offset value using the provided parameter's value, after filtering it
     * through the specified filter, or sets it to the default offset value if no
     * offset parameter is provided.
     *
     * @return void
     * @throws Exception
     * @throws \Exception
     */
    public function initializeOffset(): void
    {
        $this->setOffset($this->getParam('offset', [Filter::FILTER_ABSINT], $this->defaultOffset()));
    }
    
    /**
     * Sets the offset value for the query.
     *
     * @param int|null $offset The offset value to set for the query. Specify an integer representing the offset value or null if no offset is required.
     * @return void
     * @throws \Exception If the specified offset value is less than 0.
     */
    public function setOffset(?int $offset): void
    {
        if ($offset < 0) {
            throw new \Exception("Query offset ({$offset}) must be higher than or equal to 0", 400);
        }
        
        $this->offset = $offset;
    }
    
    /**
     * Returns the offset value.
     *
     * @return int|null The offset value. Returns either an integer representing the offset value or null if no offset is set.
     */
    public function getOffset(): ?int
    {
        return $this->offset;
    }
    
    /**
     * Returns the default offset value.
     *
     * @return int|null The default offset value. Returns either an integer representing the offset value or null if no offset is set.
     */
    public function defaultOffset(): ?int
    {
        return 0;
    }
}
