<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Dispatcher;

use JetBrains\PhpStorm\NoReturn;
use Phalcon\Http\Response;
use Phalcon\Http\ResponseInterface;
use Zemit\Di\Injectable;

/**
 * Class Preflight
 *
 * The Preflight class is attached to the dispatcher events manager.
 * It handles Cross-Origin Resource Sharing (CORS) requests and preflight
 * requests by setting the appropriate headers on the response object.
 */
class Preflight extends Injectable
{
    /**
     * This method is called before routing the request. It checks if the request is a CORS (Cross-Origin Resource Sharing) request.
     * If it is a CORS request, it retrieves the origin from the request headers and sets the CORS headers on the response object using the setCorsHeaders() method.
     * The CORS headers are determined by the "response.corsHeaders" configuration option.
     *
     * After setting the CORS headers, it checks if the request is a preflight request.
     * If it is a preflight request, it calls the sendNoContent() method to send a "204 No Content" response.
     *
     * @return void
     */
    public function beforeExecuteRoute(): void
    {
        if ($this->request->isCors()) {
            
            $origin = $this->request->getHeader('Origin');
            $headers = $this->config->pathToArray('response.corsHeaders') ?? [];
            $this->setCorsHeaders($this->response, $origin, $headers);
        }
        
        if ($this->request->isPreflight()) {
            $this->sendNoContent($this->response);
        }
    }
    
    /**
     * Set the CORS headers for the response.
     *
     * This method sets the CORS (Cross-Origin Resource Sharing) headers on the given response object.
     *
     * @param ResponseInterface $response The response object to set the headers on.
     * @param string $origin The origin value to be checked against the allowed origins.
     * @param array $headers An optional array of additional headers to be set on the response.
     *                       Each header should be represented as key-value pairs in the array.
     *                       The keys represent the header names, and the values represent the header values.
     *                       If a header key exists in the response object, it will not be overwritten.
     * @return void
     */
    public function setCorsHeaders(ResponseInterface $response, string $origin, array $headers = []): void
    {
        // Set cors headers
        foreach ($headers as $headerKey => $headerValue) {
            if (!$response->hasHeader($headerKey) && !is_array($headerValue)) {
                $response->setHeader($headerKey, $headerValue);
            }
        }
        
        // Set origin value if origin is allowed
        $originKey = 'Access-Control-Allow-Origin';
        if (!$response->hasHeader($originKey)
            && is_array($headers[$originKey])
            && in_array($origin, $headers[$originKey])
        ) {
            $response->setHeader($originKey, $origin);
        }
    }
    
    /**
     * Send a "No Content" response.
     *
     * This method sends a "No Content" response by setting the status code to 204 and sending the response.
     * After sending the response, the script execution is terminated by calling the exit function with a status code of 0.
     *
     * @param ResponseInterface $response The response object to send.
     * @return void
     */
    #[NoReturn]
    public function sendNoContent(ResponseInterface $response): void
    {
        $response->setStatusCode(204)->send();
        exit(0);
    }
}
