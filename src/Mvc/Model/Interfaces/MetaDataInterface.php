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

namespace PhalconKit\Mvc\Model\Interfaces;

interface MetaDataInterface
{
    public function getColumnMap(): ?array;

    public function getPrimaryKeys(): array;

    public function getPrimaryKeysValues(): array;
}
