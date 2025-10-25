<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Modules\Api\Transformers;

use Zemit\Fractal\Transformer;
use Zemit\Models\Record;

class RecordTransformer extends Transformer
{
    public function transform(?Record $record): array
    {
        return $record? $record->toArray() : [];
    }
}
