<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller;

use Phalcon\Http\Response;
use Zemit\Mvc\Dispatcher;

/**
 * Trait StatusCode
 * Mostly designed for Error Controllers
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @property Dispatcher $dispatcher
 * @property Response $response
 * @package Zemit\Mvc\Controller
 */
trait StatusCode
{
    /**
     * Http Status Code - Dynamic
     * index
     */
    public function indexAction($code = null)
    {
        $code ??= $this->dispatcher->getParam('code');
        $code = $code instanceof \Exception ? $code->getCode() : $code;
        $code = $code ?: 500;
        $this->setStatusCode($code);
    }
    
    /**
     * Http Status Code 100
     * continue
     */
    public function continueAction()
    {
        $this->setStatusCode(100);
    }
    
    /**
     * Http Status Code 101
     * switching-protocols
     */
    public function switchingProtocolsAction()
    {
        $this->setStatusCode(101);
    }
    
    /**
     * Http Status Code 102
     * processing
     */
    public function processingAction()
    {
        $this->setStatusCode(102);
    }
    
    /**
     * Http Status Code 200
     * ok
     */
    public function okAction()
    {
        $this->setStatusCode(200);
    }
    
    /**
     * Http Status Code 201
     * created
     */
    public function createdAction()
    {
        $this->setStatusCode(201);
    }
    
    /**
     * Http Status Code 202
     * accepted
     */
    public function acceptedAction()
    {
        $this->setStatusCode(202);
    }
    
    /**
     * Http Status Code 203
     * non-authoritative-information
     */
    public function nonAuthoritativeInformationAction()
    {
        $this->setStatusCode(203);
    }
    
    /**
     * Http Status Code 204
     * no-content
     */
    public function noContentAction()
    {
        $this->setStatusCode(204);
    }
    
    /**
     * Http Status Code 205
     * reset-content
     */
    public function resetContentAction()
    {
        $this->setStatusCode(205);
    }
    
    /**
     * Http Status Code 206
     * partial-content
     */
    public function partialContentAction()
    {
        $this->setStatusCode(206);
    }
    
    /**
     * Http Status Code 207
     * multi-status
     */
    public function multiStatusAction()
    {
        $this->setStatusCode(207);
    }
    
    /**
     * Http Status Code 208
     * already-reported
     */
    public function alreadyReportedAction()
    {
        $this->setStatusCode(208);
    }
    
    /**
     * Http Status Code 226
     * im-used
     */
    public function imUsedAction()
    {
        $this->setStatusCode(226);
    }
    
    /**
     * Http Status Code 300
     * multiple-choices
     */
    public function multipleChoicesAction()
    {
        $this->setStatusCode(300);
    }
    
    /**
     * Http Status Code 301
     * moved-permanently
     */
    public function movedPermanentlyAction()
    {
        $this->setStatusCode(301);
    }
    
    /**
     * Http Status Code 302
     * found
     */
    public function foundAction()
    {
        $this->setStatusCode(302);
    }
    
    /**
     * Http Status Code 303
     * see-other
     */
    public function seeOtherAction()
    {
        $this->setStatusCode(303);
    }
    
    /**
     * Http Status Code 304
     * not-modified
     */
    public function notModifiedAction()
    {
        $this->setStatusCode(304);
    }
    
    /**
     * Http Status Code 305
     * use-proxy
     */
    public function useProxyAction()
    {
        $this->setStatusCode(305);
    }
    
    /**
     * Http Status Code 306
     * switch-proxy
     */
    public function switchProxyAction()
    {
        $this->setStatusCode(306);
    }
    
    /**
     * Http Status Code 307
     * temporary-redirect
     */
    public function temporaryRedirectAction()
    {
        $this->setStatusCode(307);
    }
    
    /**
     * Http Status Code 308
     * permanent-redirect
     */
    public function permanentRedirectAction()
    {
        $this->setStatusCode(308);
    }
    
    /**
     * Http Status Code 400
     * bad-request
     */
    public function badRequestAction()
    {
        $this->setStatusCode(400);
    }
    
    /**
     * Http Status Code 401
     * unauthorized
     */
    public function unauthorizedAction()
    {
        $this->setStatusCode(401);
    }
    
    /**
     * Http Status Code 402
     * payment-required
     */
    public function paymentRequiredAction()
    {
        $this->setStatusCode(402);
    }
    
    /**
     * Http Status Code 403
     * forbidden
     */
    public function forbiddenAction()
    {
        $this->setStatusCode(403);
    }
    
    /**
     * Http Status Code 404
     * not-found
     */
    public function notFoundAction()
    {
        $this->setStatusCode(404);
    }
    
    /**
     * Http Status Code 405
     * method-not-allowed
     */
    public function methodNotAllowedAction()
    {
        $this->setStatusCode(405);
    }
    
    /**
     * Http Status Code 406
     * not-acceptable
     */
    public function notAcceptableAction()
    {
        $this->setStatusCode(406);
    }
    
    /**
     * Http Status Code 407
     * proxy-authentication-required
     */
    public function proxyAuthenticationRequiredAction()
    {
        $this->setStatusCode(407);
    }
    
    /**
     * Http Status Code 408
     * request-timeout
     */
    public function requestTimeoutAction()
    {
        $this->setStatusCode(408);
    }
    
    /**
     * Http Status Code 409
     * conflict
     */
    public function conflictAction()
    {
        $this->setStatusCode(409);
    }
    
    /**
     * Http Status Code 410
     * gone
     */
    public function goneAction()
    {
        $this->setStatusCode(410);
    }
    
    /**
     * Http Status Code 411
     * length-required
     */
    public function lengthRequiredAction()
    {
        $this->setStatusCode(411);
    }
    
    /**
     * Http Status Code 412
     * precondition-failed
     */
    public function preconditionFailedAction()
    {
        $this->setStatusCode(412);
    }
    
    /**
     * Http Status Code 413
     * request-entity-too-large
     */
    public function requestEntityTooLargeAction()
    {
        $this->setStatusCode(413);
    }
    
    /**
     * Http Status Code 414
     * request-uri-too-long
     */
    public function requestUriTooLongAction()
    {
        $this->setStatusCode(414);
    }
    
    /**
     * Http Status Code 415
     * unsupported-media-type
     */
    public function unsupportedMediaTypeAction()
    {
        $this->setStatusCode(415);
    }
    
    /**
     * Http Status Code 416
     * requested-range-not-satisfiable
     */
    public function requestedRangeNotSatisfiableAction()
    {
        $this->setStatusCode(416);
    }
    
    /**
     * Http Status Code 417
     * expectation-failed
     */
    public function expectationFailedAction()
    {
        $this->setStatusCode(417);
    }
    
    /**
     * Http Status Code 418
     * im-ateapot
     */
    public function imATeapotAction()
    {
        $this->setStatusCode(418);
    }
    
    /**
     * Http Status Code 419
     * authentication-timeout
     */
    public function authenticationTimeoutAction()
    {
        $this->setStatusCode(419);
    }
    
    /**
     * Http Status Code 420
     * method-failure
     */
    public function methodFailureAction()
    {
        $this->setStatusCode(420);
    }
    
    /**
     * Http Status Code 422
     * unprocessable-entity
     */
    public function unprocessableEntityAction()
    {
        $this->setStatusCode(422);
    }
    
    /**
     * Http Status Code 423
     * locked
     */
    public function lockedAction()
    {
        $this->setStatusCode(423);
    }
    
    /**
     * Http Status Code 424
     * failed-dependency
     */
    public function failedDependencyAction()
    {
        $this->setStatusCode(424);
    }
    
    /**
     * Http Status Code 426
     * upgrade-required
     */
    public function upgradeRequiredAction()
    {
        $this->setStatusCode(426);
    }
    
    /**
     * Http Status Code 428
     * precondition-required
     */
    public function preconditionRequiredAction()
    {
        $this->setStatusCode(428);
    }
    
    /**
     * Http Status Code 429
     * too-many-requests
     */
    public function tooManyRequestsAction()
    {
        $this->setStatusCode(429);
    }
    
    /**
     * Http Status Code 431
     * request-header-fields-too-large
     */
    public function requestHeaderFieldsTooLargeAction()
    {
        $this->setStatusCode(431);
    }
    
    /**
     * Http Status Code 440
     * login-timeout
     */
    public function loginTimeoutAction()
    {
        $this->setStatusCode(440);
    }
    
    /**
     * Http Status Code 444
     * no-response
     */
    public function noResponseAction()
    {
        $this->setStatusCode(444);
    }
    
    /**
     * Http Status Code 449
     * retry-with
     */
    public function retryWithAction()
    {
        $this->setStatusCode(449);
    }
    
    /**
     * Http Status Code 450
     * blocked-by-windows-parental-controls
     */
    public function blockedByWindowsParentalControlsAction()
    {
        $this->setStatusCode(450);
    }
    
    /**
     * Http Status Code 451
     * unavailable-for-legal-reasons
     */
    public function unavailableForLegalReasonsAction()
    {
        $this->setStatusCode(451);
    }
    
    /**
     * Http Status Code 494
     * request-header-too-large
     */
    public function requestHeaderTooLargeAction()
    {
        $this->setStatusCode(494);
    }
    
    /**
     * Http Status Code 495
     * cert-error
     */
    public function certErrorAction()
    {
        $this->setStatusCode(495);
    }
    
    /**
     * Http Status Code 496
     * no-cert
     */
    public function noCertAction()
    {
        $this->setStatusCode(496);
    }
    
    /**
     * Http Status Code 497
     * http-to-https
     */
    public function httpToHttpsAction()
    {
        $this->setStatusCode(497);
    }
    
    /**
     * Http Status Code 498
     * token-expiredinvalid
     */
    public function tokenExpiredinvalidAction()
    {
        $this->setStatusCode(498);
    }
    
    /**
     * Http Status Code 499
     * client-closed-request
     */
    public function clientClosedRequestAction()
    {
        $this->setStatusCode(499);
    }
    
    /**
     * Http Status Code 500
     * internal-server-error
     */
    public function internalServerErrorAction()
    {
        $this->setStatusCode(500);
    }
    
    /**
     * Http Status Code 501
     * not-implemented
     */
    public function notImplementedAction()
    {
        $this->setStatusCode(501);
    }
    
    /**
     * Http Status Code 502
     * bad-gateway
     */
    public function badGatewayAction()
    {
        $this->setStatusCode(502);
    }
    
    /**
     * Http Status Code 503
     * service-unavailable
     */
    public function serviceUnavailableAction()
    {
        $this->setStatusCode(503);
    }
    
    /**
     * Http Status Code 504
     * gateway-timeout
     */
    public function gatewayTimeoutAction()
    {
        $this->setStatusCode(504);
    }
    
    /**
     * Http Status Code 505
     * http-version-not-supported
     */
    public function httpVersionNotSupportedAction()
    {
        $this->setStatusCode(505);
    }
    
    /**
     * Http Status Code 506
     * variant-also-negotiates
     */
    public function variantAlsoNegotiatesAction()
    {
        $this->setStatusCode(506);
    }
    
    /**
     * Http Status Code 507
     * insufficient-storage
     */
    public function insufficientStorageAction()
    {
        $this->setStatusCode(507);
    }
    
    /**
     * Http Status Code 508
     * loop-detected
     */
    public function loopDetectedAction()
    {
        $this->setStatusCode(508);
    }
    
    /**
     * Http Status Code 509
     * bandwidth-limit-exceeded
     */
    public function bandwidthLimitExceededAction()
    {
        $this->setStatusCode(509);
    }
    
    /**
     * Http Status Code 510
     * not-extended
     */
    public function notExtendedAction()
    {
        $this->setStatusCode(510);
    }
    
    /**
     * Http Status Code 511
     * network-authentication-required
     */
    public function networkAuthenticationRequiredAction()
    {
        $this->setStatusCode(511);
    }
    
    /**
     * Http Status Code 598
     * network-read-timeout-error
     */
    public function networkReadTimeoutErrorAction()
    {
        $this->setStatusCode(598);
    }
    
    /**
     * Http Status Code 599
     * network-connect-timeout-error
     */
    public function networkConnectTimeoutErrorAction()
    {
        $this->setStatusCode(599);
    }
    
    /**
     * Http Status Code 500
     * fatal alias to internal-server-error
     */
    public function fatalAction()
    {
        $this->dispatcher->forward(['action' => 'internal-server-error']);
    }
    
    /**
     * Http Status Code 503
     * maintenance alias to service-unavailable
     */
    public function maintenanceAction()
    {
        $this->dispatcher->forward(['action' => 'service-unavailable']);
    }
    
    /**
     * Set the status code to the response
     *
     * @param $code
     *
     * @return \Phalcon\Http\ResponseInterface
     */
    public function setStatusCode($code)
    {
        $code = $code ?: 500;
        return $this->response->setStatusCode($code, \Zemit\Http\StatusCode::getMessage($code));
    }
}
