<?php

namespace App\Library;

/**
 * Class HttpStatusCodes
 * @deprecated Just as an example, re-implement this class correctly
 * @package Zemit\Http
 */
class HttpStatusCodes
{
    /**
     * Informational
     */
    const CODE_100 = 'Continue';
    const CODE_101 = 'Switching Protocols';
    const CODE_102 = 'Processing';
    
    /**
     * Success
     */
    const CODE_200 = 'OK';
    const CODE_201 = 'Created';
    const CODE_202 = 'Accepted';
    const CODE_203 = 'Non-Authoritative Information';
    const CODE_204 = 'No Content';
    const CODE_205 = 'Reset Content';
    const CODE_206 = 'Partial Content';
    const CODE_207 = 'Multi-Status';
    const CODE_208 = 'Already Reported';
    const CODE_226 = 'IM Used';
    
    
    /**
     * Redirection
     */
    const CODE_300 = 'Multiple Choices';
    const CODE_301 = 'Moved Permanently';
    const CODE_302 = 'Found';
    const CODE_303 = 'See Other';
    const CODE_304 = 'Not Modified';
    const CODE_305 = 'Use Proxy';
    const CODE_306 = 'Switch Proxy';
    const CODE_307 = 'Temporary Redirect';
    const CODE_308 = 'Permanent Redirect';
    
    /**
     * Client Error
     */
    const CODE_400 = 'Bad Request';
    const CODE_401 = 'Unauthorized';
    const CODE_402 = 'Payment Required';
    const CODE_403 = 'Forbidden';
    const CODE_404 = 'Not Found';
    const CODE_405 = 'Method Not Allowed';
    const CODE_406 = 'Not Acceptable';
    const CODE_407 = 'Proxy Authentication Required';
    const CODE_408 = 'Request Timeout';
    const CODE_409 = 'Conflict';
    const CODE_410 = 'Gone';
    const CODE_411 = 'Length Required';
    const CODE_412 = 'Precondition Failed';
    const CODE_413 = 'Request Entity Too Large';
    const CODE_414 = 'Request-URI Too Long';
    const CODE_415 = 'Unsupported Media Type';
    const CODE_416 = 'Requested Range Not Satisfiable';
    const CODE_417 = 'Expectation Failed';
    const CODE_418 = "I'm a teapot";
    const CODE_419 = 'Authentication Timeout';
    const CODE_420 = 'Method Failure';
    const CODE_422 = 'Unprocessable Entity';
    const CODE_423 = 'Locked';
    const CODE_424 = 'Failed Dependency';
    const CODE_426 = 'Upgrade Required';
    const CODE_428 = 'Precondition Required';
    const CODE_429 = 'Too Many Requests';
    const CODE_431 = 'Request Header Fields Too Large';
    const CODE_440 = 'Login Timeout';
    const CODE_444 = 'No Response';
    const CODE_449 = 'Retry With';
    const CODE_450 = 'Blocked by Windows Parental Controls';
    const CODE_451 = 'Unavailable For Legal Reasons';
    const CODE_494 = 'Request Header Too Large'; // nginx
    const CODE_495 = 'Cert Error'; // nginx
    const CODE_496 = 'No Cert'; // nginx
    const CODE_497 = 'HTTP to HTTPS'; // nginx
    const CODE_498 = 'Token expired/invalid'; // Esri
    const CODE_499 = 'Client Closed Request'; // Nginx
    
    /**
     * Server Error
     */
    const CODE_500 = 'Internal Server Error';
    const CODE_501 = 'Not Implemented';
    const CODE_502 = 'Bad Gateway';
    const CODE_503 = 'Service Unavailable';
    const CODE_504 = 'Gateway Timeout';
    const CODE_505 = 'HTTP Version Not Supported';
    const CODE_506 = 'Variant Also Negotiates';
    const CODE_507 = 'Insufficient Storage';
    const CODE_508 = 'Loop Detected';
    const CODE_509 = 'Bandwith Limit Exceeded';
    const CODE_510 = 'Not Extended';
    const CODE_511 = 'Network Authentication Required';
    const CODE_598 = 'Network read timeout error';
    const CODE_599 = 'Network connect timeout error';
    
    const STATUS_OK = 200;
    const STATUS_BAD_REQUEST = 400;
    const STATUS_UNAUTHORIZED = 401;
    const STATUS_NOT_FOUND = 404;
    const STATUS_FORBIDDEN = 403;
    const STATUS_FATAL_ERROR = 500;
    const STATUS_INTERNAL_SERVER_ERROR = 500;
    const STATUS_MAINTENANCE = 503;
    
    /**
     * Get the HTTP status message for the specified HTTP status code
     * @param $code
     * @return mixed
     */
    public static function getMessage($code)
    {
        return constant('self::CODE_' . $code);
    }
}
