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

namespace PhalconKit\Fractal\Serializer;

use League\Fractal\Serializer\ArraySerializer;

/**
 * Class RawArraySerializer
 *
 * This class is responsible for serializing data in the form of arrays.
 * It extends the ArraySerializer class and provides methods for serializing
 * collections, items, and null values.
 */
class RawArraySerializer extends ArraySerializer
{
    /**
     * {@inheritDoc}
     */
    #[\Override]
    public function collection(?string $resourceKey, array $data): array
    {
        return $data;
    }
    
    /**
     * {@inheritDoc}
     */
    #[\Override]
    public function item(?string $resourceKey, array $data): array
    {
        return $data;
    }
    
    /**
     * {@inheritDoc}
     */
    #[\Override]
    public function null(): ?array
    {
        return [];
    }
}
