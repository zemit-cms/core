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

use Zemit\Models\Abstracts\SiteLangAbstract;
use Zemit\Models\Interfaces\SiteLangInterface;

/**
 * Class SiteLang
 *
 * This class represents a SiteLang object.
 * It extends the SiteLangAbstract class and implements the SiteLangInterface.
 */
class SiteLang extends SiteLangAbstract implements SiteLangInterface
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