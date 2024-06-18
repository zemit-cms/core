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

use Exception;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractExport;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractModel;

trait ExportAction
{
    use AbstractModel;
    use AbstractExport;
    
    /**
     * Exporting a record list into a CSV stream
     * @throws Exception
     */
    public function exportAction(): void
    {
        $model = $this->getModelName();
        $find = $this->getFind();
        $with = $model::findWith($this->getExportWith() ?: [], $find ?: []);
        $list = $this->exportExpose($with);
        if ($this->export($list)) {
            // @todo avoid sending response instead of die
            exit(200);
        }
    }
    
}
