<?php

declare(strict_types=1);

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit Team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace PhalconKit\Mvc\Controller\Traits\Query;

use PhalconKit\Mvc\Controller\Traits\Abstracts\Query\AbstractFields;
use PhalconKit\Mvc\Controller\Traits\Query\Fields\ExposeFields;
use PhalconKit\Mvc\Controller\Traits\Query\Fields\FilterFields;
use PhalconKit\Mvc\Controller\Traits\Query\Fields\MapFields;
use PhalconKit\Mvc\Controller\Traits\Query\Fields\SaveFields;
use PhalconKit\Mvc\Controller\Traits\Query\Fields\SearchFields;

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
