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
 
namespace Zemit\Models;

use Zemit\Models\Abstracts\PhalconMigrationsAbstract;
use Zemit\Models\Interfaces\PhalconMigrationsInterface;

/**
 * Class PhalconMigrations
 *
 * This class represents a PhalconMigrations model.
 * It extends the PhalconMigrationsAbstract class and implements the PhalconMigrationsInterface.
 */
class PhalconMigrations extends PhalconMigrationsAbstract implements PhalconMigrationsInterface
{
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