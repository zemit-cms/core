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

use PhalconKit\Models\Abstracts\SettingAbstract;
use PhalconKit\Models\Interfaces\SettingInterface;

/**
 * Class Setting
 *
 * This class represents a Setting object.
 * It extends the SettingAbstract class and implements the SettingInterface.
 */
class Setting extends SettingAbstract implements SettingInterface
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
