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

namespace PhalconKit\Models;

use PhalconKit\Models\Abstracts\PhalconMigrationsAbstract;
use PhalconKit\Models\Interfaces\PhalconMigrationsInterface;

/**
 * Class PhalconMigrations
 *
 * This class represents a PhalconMigrations object.
 * It extends the PhalconMigrationsAbstract class and implements the PhalconMigrationsInterface.
 */
class PhalconMigrations extends PhalconMigrationsAbstract implements PhalconMigrationsInterface
{
    #[\Override]
    public function initialize(): void
    {
        parent::initialize();
        $this->addDefaultRelationships();
    }

    public function validation(): bool
    {
        $validator = $this->genericValidation();
        $this->addDefaultValidations($validator);
        return $this->validate($validator);
    }
}
