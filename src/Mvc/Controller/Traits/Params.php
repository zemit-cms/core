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

use Phalcon\Filter\Exception;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractInjectable;

trait Params
{
    use AbstractInjectable;
    
    /**
     * Get a specific parameter value by key.
     *
     * @param string $key The key of the parameter.
     * @param array|string|null $filters Optional. The filters to apply to the parameter value. Defaults to null.
     * @param mixed $default Optional. The default value if the parameter does not exist. Defaults to null.
     * @param array|null $params Optional. The array of parameters to search from. Defaults to null.
     *
     * @return mixed The value of the specified parameter, after applying the filters if provided. If the parameter does not exist,
     *               then the default value is returned if provided. If both the parameter and the default value are missing,
     *               then the value from the dispatcher's parameter is returned.
     * @throws Exception
     */
    public function getParam(string $key, array|string|null $filters = null, mixed $default = null, array $params = null): mixed
    {
        $params ??= $this->getParams();
        
        return isset($params[$key])
            ? ($filters ? $this->filter->sanitize($params[$key], $filters) : $params[$key])
            : $this->dispatcher->getParam($key, $filters, $default);
    }
    
    /**
     * Retrieves the request parameters.
     *
     * @param array|null $filters An optional array of filters to apply to the parameters.
     * @return array The request parameters.
     */
    public function getParams(array $filters = null): array
    {
        if (!empty($filters)) {
            foreach ($filters as $filter) {
                $this->request->setParameterFilters($filter['name'], $filter['filters'], $filter['scope']);
            }
        }

        $params = array_merge_recursive(
            $this->request->getFilteredQuery(), // $_GET
            $this->request->getFilteredPut(), // $_PUT
            $this->request->getFilteredPost(), // $_POST
        );
        
        // remove default phalcon _url param
        if (isset($params['_url'])) {
            unset($params['_url']);
        }
        
        return $params;
    }
    
}
