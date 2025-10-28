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

use Zemit\Mvc\Controller\Traits\Abstracts\Query\AbstractFields;
use Zemit\Mvc\Controller\Traits\Query\Fields\ExposeFields;
use Zemit\Mvc\Controller\Traits\Query\Fields\FilterFields;
use Zemit\Mvc\Controller\Traits\Query\Fields\MapFields;
use Zemit\Mvc\Controller\Traits\Query\Fields\SaveFields;
use Zemit\Mvc\Controller\Traits\Query\Fields\SearchFields;

trait Fields
{
    use AbstractFields;
    
    use ExposeFields;
    use FilterFields;
    use MapFields;
    use SaveFields;
    use SearchFields;
    
    public function initializeFields(): void
    {
        $this->initializeExposeFields();
        $this->initializeFilterFields();
        $this->initializeMapFields();
        $this->initializeSaveFields();
        $this->initializeSearchFields();
    }
}
