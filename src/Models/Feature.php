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

use Zemit\Models\Abstracts\FeatureAbstract;
use Zemit\Models\Interfaces\FeatureInterface;

/**
 * Class Feature
 *
 * This class represents a Feature object.
 * It extends the FeatureAbstract class and implements the FeatureInterface.
 */
class Feature extends FeatureAbstract implements FeatureInterface
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
