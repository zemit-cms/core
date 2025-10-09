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

enum TranslateTableTable: string {
    case PAGE = 'page';
    case POST = 'post';
    case CATEGORY = 'category';
}