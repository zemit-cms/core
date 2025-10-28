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

namespace Zemit\Mvc\Controller\Traits\Actions\Rest;

use Exception;
use Phalcon\Http\ResponseInterface;
use Phalcon\Mvc\Model\Resultset;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractExport;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractExpose;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractModel;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractQuery;

trait ExportAction
{
    use AbstractExpose;
    use AbstractExport;
    use AbstractModel;
    use AbstractQuery;
    
    /**
     * Export the data and end the script execution.
     *
     * This method retrieves the data by calling the `find` method and then
     * exposes it using the `exportExpose` method. If the data is successfully
     * exported using the `export` method, the script execution is ended by
     * calling `exit` with a status code of 0.
     *
     * @return ResponseInterface
     * @throws Exception
     */
    public function exportAction(): ResponseInterface
    {
        $resultset = $this->find();
        assert($resultset instanceof Resultset);
        $data = $this->exportExpose($resultset);
        return $this->export($data);
    }
}
