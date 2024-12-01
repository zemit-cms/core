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

enum ColumnType: string {
    case LINK_TO_ANOTHER_RECORD = 'linkToAnotherRecord';
    case SINGLE_LINE_TEXT = 'singleLineText';
    case LONG_TEXT = 'longText';
    case ATTACHMENT = 'attachment';
    case CHECKBOX = 'checkbox';
    case MULTIPLE_SELECT = 'multipleSelect';
    case SINGLE_SELECT = 'singleSelect';
    case USER = 'user';
    case DATE = 'date';
    case PHONE_NUMBER = 'phoneNumber';
    case EMAIL = 'email';
    case URL = 'url';
    case NUMBER = 'number';
    case CURRENCY = 'currency';
    case PERCENT = 'percent';
    case DURATION = 'duration';
    case RATING = 'rating';
    case FORMULA = 'formula';
    case ROLLUP = 'rollup';
    case COUNT = 'count';
    case LOOKUP = 'lookup';
    case CREATED_TIME = 'createdTime';
    case LAST_MODIFIED_TIME = 'lastModifiedTime';
    case CREATED_BY = 'createdBy';
    case LAST_MODIFIED_BY = 'lastModifiedBy';
    case AUTONUMBER = 'autonumber';
    case BARCODE = 'barcode';
    case BUTTON = 'button';
}