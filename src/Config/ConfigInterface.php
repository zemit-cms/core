<?php

declare(strict_types=1);

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Config;

interface ConfigInterface extends \Phalcon\Config\ConfigInterface
{
    public function pathToArray(string $path, ?array $defaultValue = null, ?string $delimiter = null): ?array;
}
