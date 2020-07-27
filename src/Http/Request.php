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
 * Class Request
 * {@inheritDoc}
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Http
 */
class Request extends \Phalcon\Http\Request
{
    public function toArray()
    {
        $config = $this->getDI()->get('config');
        if ($config->app->debug || $config->debug->enable) {
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
                'isValidHttpMethod' => $this->isValidHttpMethod($this->getMethod()),
            ];
        }
        return false;
    }
}
