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

use PhalconKit\Models\Abstracts\SiteLangAbstract;
use PhalconKit\Models\Interfaces\SiteLangInterface;

/**
 * Class SiteLang
 *
 * This class represents a SiteLang object.
 * It extends the SiteLangAbstract class and implements the SiteLangInterface.
 */
class SiteLang extends SiteLangAbstract implements SiteLangInterface
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
