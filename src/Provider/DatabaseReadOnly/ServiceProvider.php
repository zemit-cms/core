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

namespace Zemit\Provider\DatabaseReadOnly;

class ServiceProvider extends \Zemit\Provider\Database\ServiceProvider
{
    protected ?string $driverName = 'readonly';
    protected string $serviceName = 'dbr';
}
