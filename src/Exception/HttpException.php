<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Exception;

use Exception;
use Throwable;

/**
 * Zemit\Exception\HttpException
 *
 * @package Zemit\Exception
 */
class HttpException extends Exception
{
    public function __construct(string $message, int $code, Throwable $exception = null)
    {
        parent::__construct($message, $code, $exception);
    }
}
