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

use Phalcon\Events\Event;
use Phalcon\Http\Response;
use Zemit\Bootstrap\Config;
use Zemit\Di\Injectable;
use Zemit\Mvc\Dispatcher;
use Zemit\Http\Request;

/**
 * Class Preflight
 */
class Preflight extends Injectable
{
    /**
     * @param Event $event
     * @param Dispatcher $dispatcher
     */
    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        $di = $dispatcher->getDI();
        
        /** @var Response $response */
        $response = $di->get('response');
        
        /** @var Request $request */
        $request = $di->get('request');
        
        if ($request->isCors()) {
            
            /** @var Config $request */
            $config = $di->get('config');
            
            $this->setCorsHeaders($response,
                $request->getHeader('Origin'),
                $config->path('response.corsHeaders', [])->toArray()
            );
        }
        
        if ($request->isPreflight()) {
            $this->sendNoContent($response);
        }
    }
    
    public function setCorsHeaders(Response $response, string $origin, array $headers = [])
    {
        // Set default cors headers
        if (!empty($headers)) {
            foreach ($headers as $headerKey => $headerValue) {
                if (!$response->hasHeader($headerKey) && !is_array($headerValue)) {
                    $response->setHeader($headerKey, $headerValue);
                }
            }
        }
        
        // Set default origin value if allowed
        $originKey = 'Access-Control-Allow-Origin';
        if (!$response->hasHeader($originKey)
            && is_array($headers[$originKey])
            && in_array($origin, $headers[$originKey])
        ) {
            $response->setHeader($originKey, $origin);
        }
    }
    
    /**
     * Send 204 no content response & exit application
     * @param Response $response
     * @return void
     */
    public function sendNoContent(Response $response)
    {
        $response->setStatusCode(204)->send();
        exit;
    }
}
