<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Http;

/**
 * Represents an HTTP request.
 * {@inheritDoc}
 */
class Request extends \Phalcon\Http\Request implements RequestInterface
{
    /**
     * Return true if the request is a Cross-Origin Resource Sharing (CORS) request
     *
     * @return bool True if the request is a CORS request, false otherwise
     */
    #[\Override]
    public function isCors(): bool
    {
        return !empty($this->getHeader('Origin')) && !$this->isSameOrigin();
    }
    
    /**
     * Return true if the request is a preflight request
     *
     * A preflight request is a CORS (Cross-Origin Resource Sharing) request that is sent by a browser
     * prior to the actual request to determine the permissions to make the actual request.
     *
     * A preflight request must meet the following conditions:
     * 
     * - The request must be a CORS request.
     * - The request method must be OPTIONS.
     * - The request must contain a non-empty Access-Control-Request-Method header.
     *
     * @return bool True if the request is a preflight request, false otherwise.
     */
    #[\Override]
    public function isPreflight(): bool
    {
        return $this->isCors()
            && $this->isOptions()
            && !empty($this->getHeader('Access-Control-Request-Method'));
    }
    
    /**
     * Checks if the request is from the same origin.
     *
     * @return bool Returns true if the request is from the same origin, false otherwise.
     */
    #[\Override]
    public function isSameOrigin(): bool
    {
        $schemeHost = $this->getScheme() . '://' . $this->getHttpHost();
        return $this->getHeader('Origin') === $schemeHost;
    }
    
    /**
     * Converts the request object to an array.
     *
     * @return array An associative array containing various properties of the request object:
     * 
     *               - body: The raw body of the request.
     *               - post: An array containing the POST parameters.
     *               - get: An array containing the GET parameters.
     *               - put: An array containing the PUT parameters.
     *               - headers: An associative array containing the request headers.
     *               - userAgent: The user agent string.
     *               - basicAuth: The value of the Basic Authorization header.
     *               - bestAccept: The best Accept header value based on server preferences.
     *               - bestCharset: The best charset value based on server preferences.
     *               - bestLanguage: The best language value based on server preferences.
     *               - clientAddress: The client IP address.
     *               - clientCharsets: An array of charsets supported by the client.
     *               - contentType: The content type of the request.
     *               - digestAuth: The value of the Digest Authorization header.
     *               - httpHost: The HTTP host value.
     *               - uri: The request URI.
     *               - serverName: The server name.
     *               - serverAddress: The server IP address.
     *               - method: The HTTP request method.
     *               - port: The server port.
     *               - httpReferer: The referer URL.
     *               - languages: An array of preferred languages.
     *               - scheme: The URI scheme.
     *               - isAjax: True if the request is an AJAX request, false otherwise.
     *               - isGet: True if the request is a GET request, false otherwise.
     *               - isDelete: True if the request is a DELETE request, false otherwise.
     *               - isHead: True if the request is a HEAD request, false otherwise.
     *               - isPatch: True if the request is a PATCH request, false otherwise.
     *               - isConnect: True if the request is a CONNECT request, false otherwise.
     *               - isTrace: True if the request is a TRACE request, false otherwise.
     *               - isPut: True if the request is a PUT request, false otherwise.
     *               - isPurge: True if the request is a PURGE request, false otherwise.
     *               - isOptions: True if the request is an OPTIONS request, false otherwise.
     *               - isSoap: True if the request is a SOAP request, false otherwise.
     *               - isSecure: True if the request is made over a secure connection, false otherwise.
     *               - isCors: True if the request is a CORS request, false otherwise.
     *               - isPreflight: True if the request is a CORS preflight request, false otherwise.
     *               - isSameOrigin: True if the request is from the same origin, false otherwise.
     *               - isValidHttpMethod: True if the HTTP method is valid, false otherwise.
     */
    #[\Override]
    public function toArray(): array
    {
        return [
            'body' => $this->getRawBody(),
            'post' => $this->getPost(),
            'get' => $this->get(),
            'put' => $this->getPut(),
            'headers' => $this->getHeaders(),
            'userAgent' => $this->getUserAgent(),
            'basicAuth' => $this->getBasicAuth(),
            'bestAccept' => $this->getBestAccept(),
            'bestCharset' => $this->getBestCharset(),
            'bestLanguage' => $this->getBestLanguage(),
            'clientAddress' => $this->getClientAddress(),
            'clientCharsets' => $this->getClientCharsets(),
            'contentType' => $this->getContentType(),
            'digestAuth' => $this->getDigestAuth(),
            'httpHost' => $this->getHttpHost(),
            'uri' => $this->getURI(),
            'serverName' => $this->getServerName(),
            'serverAddress' => $this->getServerAddress(),
            'method' => $this->getMethod(),
            'port' => $this->getPort(),
            'httpReferer' => $this->getHTTPReferer(),
            'languages' => $this->getLanguages(),
            'scheme' => $this->getScheme(),
            'isAjax' => $this->isAjax(),
            'isGet' => $this->isGet(),
            'isDelete' => $this->isDelete(),
            'isHead' => $this->isHead(),
            'isPatch' => $this->isPatch(),
            'isConnect' => $this->isConnect(),
            'isTrace' => $this->isTrace(),
            'isPut' => $this->isPut(),
            'isPurge' => $this->isPurge(),
            'isOptions' => $this->isOptions(),
            'isSoap' => $this->isSoap(),
            'isSecure' => $this->isSecure(),
            'isCors' => $this->isCors(),
            'isPreflight' => $this->isPreflight(),
            'isSameOrigin' => $this->isSameOrigin(),
            'isValidHttpMethod' => $this->isValidHttpMethod($this->getMethod()),
        ];
    }
}
