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

use Phalcon\Http\ResponseInterface;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractInjectable;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractRestResponse;
use Zemit\Mvc\Controller\Traits\Abstracts\Query\AbstractSave;

trait SaveAction
{
    use AbstractInjectable;
    use AbstractRestResponse;
    use AbstractSave;
    
    /**
     * Save action.
     *
     * Saves the record and returns the response based on the save result.
     *
     * @return ResponseInterface The response object.
     * @throws \Exception
     */
    public function saveAction(): ResponseInterface
    {
        $ret = $this->save();
        $saved = $this->saveResultHasKey($ret, 'saved');
        $messages = $this->saveResultHasKey($ret, 'messages');
        
        if (!$saved) {
            if (!$messages) {
                $this->response->setStatusCode(422, 'Unprocessable Entity');
            }
            else {
                $this->response->setStatusCode(400, 'Bad Request');
            }
        }
        
        $this->view->setVars($ret);
        return $this->setRestResponse($saved);
    }
    
    /**
     * Return true if the record or the records where saved
     * Return false if one record wasn't saved
     * Return null if nothing was saved
     */
    public function saveResultHasKey(array $array, string $key): bool
    {
        $ret = $array[$key] ?? null;
        
        if (isset($array[0])) {
            foreach ($array as $k => $r) {
                if (isset($r[$key])) {
                    if ($r[$key]) {
                        $ret = true;
                    }
                    else {
                        $ret = false;
                        break;
                    }
                }
            }
        }
        
        return (bool)$ret;
    }
}
