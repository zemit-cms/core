<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Traits;

trait Allowed
{
    protected ?array $allowedSearchFields;
    
    protected ?array $allowedSaveFields;
    
    protected ?array $allowedFilterFields;
}
