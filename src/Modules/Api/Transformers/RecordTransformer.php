<?php

declare(strict_types=1);

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit Team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace PhalconKit\Modules\Api\Transformers;

use PhalconKit\Fractal\Transformer;
use PhalconKit\Models\Record;

class RecordTransformer extends Transformer
{
    public function transform(?Record $record): array
    {
        return $record ? $record->toArray() : [];
    }
}
