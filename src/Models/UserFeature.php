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

use Zemit\Models\Abstracts\UserFeatureAbstract;
use Zemit\Models\Interfaces\UserFeatureInterface;

/**
 * Class UserFeature
 *
 * This class represents a UserFeature model.
 * It extends the UserFeatureAbstract class and implements the UserFeatureInterface.
 */
class UserFeature extends UserFeatureAbstract implements UserFeatureInterface
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