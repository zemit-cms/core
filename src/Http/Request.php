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
 * {@inheritDoc}
 */
class Request extends \Phalcon\Http\Request implements RequestInterface
{
    /**
     * Return true if cors request
     */
    public function isCors(): bool
    {
        return !empty($this->getHeader('Origin')) && !$this->isSameOrigin();
    }

    /**
     * Return true if preflight request
     */
    public function isPreflight(): bool
    {
        return $this->isCors()
            && $this->isOptions()
            && !empty($this->getHeader('Access-Control-Request-Method'));
    }

    /**
     * Return true if the header origin is the same as the request http host
     */
    public function isSameOrigin(): bool
    {
        $schemeHost = $this->getScheme() . '://' . $this->getHttpHost();
        return $this->getHeader('Origin') === $schemeHost;
    }
    
    /**
     * Return a list of the current request attributes
     */
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
