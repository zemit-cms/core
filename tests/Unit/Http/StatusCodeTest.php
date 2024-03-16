<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Unit\Http;

use Zemit\Http\StatusCode;
use Zemit\Tests\Unit\AbstractUnit;

/**
 * Class UrlTest
 */
class StatusCodeTest extends AbstractUnit
{
    public function setUp(): void
    {
        $this->loaded = true;
    }
    
    public function testStatusCode()
    {
        $messages = [
            100 => 'Continue',
            101 => 'Switching Protocols',
            102 => 'Processing',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            207 => 'Multi-Status',
            208 => 'Already Reported',
            226 => 'IM Used',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => 'Switch Proxy',
            307 => 'Temporary Redirect',
            308 => 'Permanent Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            418 => 'I\'m a teapot',
            419 => 'Authentication Timeout',
            420 => 'Method Failure',
            422 => 'Unprocessable Entity',
            423 => 'Locked',
            424 => 'Failed Dependency',
            426 => 'Upgrade Required',
            428 => 'Precondition Required',
            429 => 'Too Many Requests',
            431 => 'Request Header Fields Too Large',
            440 => 'Login Timeout',
            444 => 'No Response',
            449 => 'Retry With',
            450 => 'Blocked by Windows Parental Controls',
            451 => 'Unavailable For Legal Reasons',
            494 => 'Request Header Too Large',
            495 => 'Cert Error',
            496 => 'No Cert',
            497 => 'HTTP to HTTPS',
            498 => 'Token expired/invalid',
            499 => 'Client Closed Request',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            506 => 'Variant Also Negotiates',
            507 => 'Insufficient Storage',
            508 => 'Loop Detected',
            509 => 'Bandwidth Limit Exceeded',
            510 => 'Not Extended',
            511 => 'Network Authentication Required',
            598 => 'Network read timeout error',
            599 => 'Network connect timeout error',
        ];
        
        // StatusCode constants
        $this->assertEquals(100, StatusCode::CONTINUE);
        $this->assertEquals(101, StatusCode::SWITCHING_PROTOCOLS);
        $this->assertEquals(102, StatusCode::PROCESSING);
        $this->assertEquals(200, StatusCode::OK);
        $this->assertEquals(201, StatusCode::CREATED);
        $this->assertEquals(202, StatusCode::ACCEPTED);
        $this->assertEquals(203, StatusCode::NON_AUTHORITATIVE_INFORMATION);
        $this->assertEquals(204, StatusCode::NO_CONTENT);
        $this->assertEquals(205, StatusCode::RESET_CONTENT);
        $this->assertEquals(206, StatusCode::PARTIAL_CONTENT);
        $this->assertEquals(207, StatusCode::MULTI_STATUS);
        $this->assertEquals(208, StatusCode::ALREADY_REPORTED);
        $this->assertEquals(226, StatusCode::IM_USED);
        $this->assertEquals(300, StatusCode::MULTIPLE_CHOICES);
        $this->assertEquals(301, StatusCode::MOVED_PERMANENTLY);
        $this->assertEquals(302, StatusCode::FOUND);
        $this->assertEquals(303, StatusCode::SEE_OTHER);
        $this->assertEquals(304, StatusCode::NOT_MODIFIED);
        $this->assertEquals(305, StatusCode::USE_PROXY);
        $this->assertEquals(306, StatusCode::SWITCH_PROXY);
        $this->assertEquals(307, StatusCode::TEMPORARY_REDIRECT);
        $this->assertEquals(308, StatusCode::PERMANENT_REDIRECT);
        $this->assertEquals(400, StatusCode::BAD_REQUEST);
        $this->assertEquals(401, StatusCode::UNAUTHORIZED);
        $this->assertEquals(402, StatusCode::PAYMENT_REQUIRED);
        $this->assertEquals(403, StatusCode::FORBIDDEN);
        $this->assertEquals(404, StatusCode::NOT_FOUND);
        $this->assertEquals(405, StatusCode::METHOD_NOT_ALLOWED);
        $this->assertEquals(406, StatusCode::NOT_ACCEPTABLE);
        $this->assertEquals(407, StatusCode::PROXY_AUTHENTICATION_REQUIRED);
        $this->assertEquals(408, StatusCode::REQUEST_TIMEOUT);
        $this->assertEquals(409, StatusCode::CONFLICT);
        $this->assertEquals(410, StatusCode::GONE);
        $this->assertEquals(411, StatusCode::LENGTH_REQUIRED);
        $this->assertEquals(412, StatusCode::PRECONDITION_FAILED);
        $this->assertEquals(413, StatusCode::REQUEST_ENTITY_TOO_LARGE);
        $this->assertEquals(414, StatusCode::REQUEST_URI_TOO_LONG);
        $this->assertEquals(415, StatusCode::UNSUPPORTED_MEDIA_TYPE);
        $this->assertEquals(416, StatusCode::REQUESTED_RANGE_NOT_SATISFIABLE);
        $this->assertEquals(417, StatusCode::EXPECTATION_FAILED);
        $this->assertEquals(418, StatusCode::IM_A_TEAPOT);
        $this->assertEquals(419, StatusCode::AUTHENTICATION_TIMEOUT);
        $this->assertEquals(420, StatusCode::METHOD_FAILURE);
        $this->assertEquals(422, StatusCode::UNPROCESSABLE_ENTITY);
        $this->assertEquals(423, StatusCode::LOCKED);
        $this->assertEquals(424, StatusCode::FAILED_DEPENDENCY);
        $this->assertEquals(426, StatusCode::UPGRADE_REQUIRED);
        $this->assertEquals(428, StatusCode::PRECONDITION_REQUIRED);
        $this->assertEquals(429, StatusCode::TOO_MANY_REQUESTS);
        $this->assertEquals(431, StatusCode::REQUEST_HEADER_FIELDS_TOO_LARGE);
        $this->assertEquals(440, StatusCode::LOGIN_TIMEOUT);
        $this->assertEquals(444, StatusCode::NO_RESPONSE);
        $this->assertEquals(449, StatusCode::RETRY_WITH);
        $this->assertEquals(450, StatusCode::BLOCKED_BY_WINDOWS_PARENTAL_CONTROLS);
        $this->assertEquals(451, StatusCode::UNAVAILABLE_FOR_LEGAL_REASONS);
        $this->assertEquals(494, StatusCode::REQUEST_HEADER_TOO_LARGE);
        $this->assertEquals(495, StatusCode::CERT_ERROR);
        $this->assertEquals(496, StatusCode::NO_CERT);
        $this->assertEquals(497, StatusCode::HTTP_TO_HTTPS);
        $this->assertEquals(498, StatusCode::TOKEN_EXPIREDINVALID);
        $this->assertEquals(499, StatusCode::CLIENT_CLOSED_REQUEST);
        $this->assertEquals(500, StatusCode::INTERNAL_SERVER_ERROR);
        $this->assertEquals(501, StatusCode::NOT_IMPLEMENTED);
        $this->assertEquals(502, StatusCode::BAD_GATEWAY);
        $this->assertEquals(503, StatusCode::SERVICE_UNAVAILABLE);
        $this->assertEquals(504, StatusCode::GATEWAY_TIMEOUT);
        $this->assertEquals(505, StatusCode::HTTP_VERSION_NOT_SUPPORTED);
        $this->assertEquals(506, StatusCode::VARIANT_ALSO_NEGOTIATES);
        $this->assertEquals(507, StatusCode::INSUFFICIENT_STORAGE);
        $this->assertEquals(508, StatusCode::LOOP_DETECTED);
        $this->assertEquals(509, StatusCode::BANDWIDTH_LIMIT_EXCEEDED);
        $this->assertEquals(510, StatusCode::NOT_EXTENDED);
        $this->assertEquals(511, StatusCode::NETWORK_AUTHENTICATION_REQUIRED);
        $this->assertEquals(598, StatusCode::NETWORK_READ_TIMEOUT_ERROR);
        $this->assertEquals(599, StatusCode::NETWORK_CONNECT_TIMEOUT_ERROR);
        
        // Dev friendly constants
        $this->assertEquals(500, StatusCode::FATAL_ERROR);
        $this->assertEquals(503, StatusCode::MAINTENANCE);
        $this->assertEquals(503, StatusCode::OVERLOADED);
        $this->assertEquals(503, StatusCode::BUSY);
        
        // Test default constants
        foreach ($messages as $code => $message) {
            $this->assertContainsEquals($code, array_keys(StatusCode::$messages));
            $this->assertContainsEquals($message, StatusCode::$messages);
    
            $this->assertEquals($message, StatusCode::$messages[$code]);
            $this->assertEquals($code, StatusCode::getCode($message));
            $this->assertEquals($message, StatusCode::getMessage($code));
            $this->assertEquals($code . ' ' . $message, StatusCode::getStatus($code));
    
            $this->assertIsString(StatusCode::$messages[$code]);
            $this->assertIsString(StatusCode::getMessage($code));
            $this->assertIsString(StatusCode::getStatus($code));
            $this->assertIsInt(StatusCode::getCode($message));
        }
        
        // Test undefined $message & status
        $this->assertNull(StatusCode::getMessage(0));
        $this->assertNull(StatusCode::getMessage(9999));
        $this->assertNull(StatusCode::getCode('0'));
        $this->assertNull(StatusCode::getCode('9999'));
        $this->assertNull(StatusCode::getCode('TEST'));
        $this->assertNull(StatusCode::getCode(''));
        
        // Test undefined for getStatus()
        $this->assertEquals('0', StatusCode::getStatus(0));
        $this->assertIsString(StatusCode::getStatus(0));
        $this->assertEquals('9999', StatusCode::getStatus(9999));
        $this->assertIsString(StatusCode::getStatus(999));
        
        // Make sure we tested everything
        $this->assertEquals(count($messages), count(StatusCode::$messages));
    }
}
