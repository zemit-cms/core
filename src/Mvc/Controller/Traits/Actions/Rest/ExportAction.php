<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Traits\Actions\Rest;

use Zemit\Mvc\Controller\Traits\Export;

trait ExportAction
{
    use Export;
    
    /**
     * Exporting a record list into a CSV stream
     * @throws \Exception
     */
    public function exportAction(): void
    {
        $model = $this->getModelClassName();
        $find = $this->getFind();
        $with = $model::findWith($this->getExportWith() ?: [], $find ?: []);
        $list = $this->exportExpose($with);
        if ($this->download($list)) {
            // @todo avoid sending response instead of die
            die;
        }
    }
    
}
