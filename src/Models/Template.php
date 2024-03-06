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

use Zemit\Models\Abstracts\TemplateAbstract;
use Zemit\Models\Interfaces\TemplateInterface;

/**
 * Class Template
 *
 * This class represents a Template object.
 * It extends the TemplateAbstract class and implements the TemplateInterface.
 */
class Template extends TemplateAbstract implements TemplateInterface
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