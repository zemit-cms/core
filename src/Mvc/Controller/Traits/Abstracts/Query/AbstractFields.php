<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Traits\Abstracts\Query;

use Zemit\Mvc\Controller\Traits\Abstracts\Query\Fields\AbstractExposeFields;
use Zemit\Mvc\Controller\Traits\Abstracts\Query\Fields\AbstractFilterFields;
use Zemit\Mvc\Controller\Traits\Abstracts\Query\Fields\AbstractMapFields;
use Zemit\Mvc\Controller\Traits\Abstracts\Query\Fields\AbstractSaveFields;
use Zemit\Mvc\Controller\Traits\Abstracts\Query\Fields\AbstractSearchFields;

trait AbstractFields
{
    use AbstractExposeFields;
    use AbstractFilterFields;
    use AbstractMapFields;
    use AbstractSaveFields;
    use AbstractSearchFields;
    
    abstract public function initializeFields(): void;
}
