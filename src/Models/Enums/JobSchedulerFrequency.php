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

namespace Zemit\Models\Enums;

enum JobSchedulerFrequency: string
{
    case MANUALLY = 'manually';
    case MINUTELY = 'minutely';
    case HOURLY = 'hourly';
    case DAILY = 'daily';
    case WEEKDAYS = 'weekdays';
    case WEEKENDS = 'weekends';
    case WEEKLY = 'weekly';
    case BI_WEEKLY = 'bi-weekly';
    case MONTHLY = 'monthly';
    case BI_MONTHLY = 'bi-monthly';
    case QUARTERLY = 'quarterly';
    case SEMI_ANNUALLY = 'semi-annually';
    case YEARLY = 'yearly';
}
