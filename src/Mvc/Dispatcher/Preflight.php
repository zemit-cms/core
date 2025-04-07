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
use Phalcon\Events\Event;
use Phalcon\Http\Response;
use Zemit\Di\Injectable;
use Zemit\Dispatcher\DispatcherInterface;

class Preflight extends Injectable
{
    /**
     * Set cors headers for cors request and send no content for preflight request
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
    
    public function setCorsHeaders(Response $response, string $origin, array $headers = []): void
    {
        // Set cors headers
        foreach ($headers as $headerKey => $headerValue) {
            if (!$response->hasHeader($headerKey) && !is_array($headerValue)) {
                
                // ignore Access-Control-Allow-Origin as we will add the header after
                if ($headerKey === 'Access-Control-Allow-Origin') {
                    continue;
                }
                
                // Ensure the bool values are sent as string
                if (is_bool($headerValue)) {
                    $headerValue = $headerValue ? 'true' : 'false';
                }
                
                // set the header
                $response->setHeader($headerKey, $headerValue);
            }
        }
        
        // Set origin value if origin is allowed
        $originKey = 'Access-Control-Allow-Origin';
        if (!$response->hasHeader($originKey) &&
            ($headers[$originKey] === '*' || (
                is_array($headers[$originKey]) &&
                (in_array($origin, $headers[$originKey])) || in_array('*', $headers[$originKey]))
            )
        ) {
            $response->setHeader($originKey, $origin);
        }
    }
    
    /**
     * Send 204 no content response & exit application successfully
     */
    #[NoReturn]
    public function sendNoContent(Response $response): void
    {
        $response->setStatusCode(204)->send();
        exit(0);
    }
}
