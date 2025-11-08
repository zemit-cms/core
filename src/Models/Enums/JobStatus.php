<?php

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit Team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PhalconKit\Models\Enums;

enum JobStatus: string
{
    case NEW = 'new';
    case PROGRESS = 'progress';
    case FAILED = 'failed';
    case FINISHED = 'finished';
}
