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

use PhalconKit\Models\Abstracts\TranslateAbstract;
use PhalconKit\Models\Interfaces\TranslateInterface;

/**
 * Class Translate
 *
 * This class represents a Translate object.
 * It extends the TranslateAbstract class and implements the TranslateInterface.
 */
class Translate extends TranslateAbstract implements TranslateInterface
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
