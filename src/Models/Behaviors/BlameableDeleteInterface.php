<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Models\Behaviors;

interface BlameableDeleteInterface
{
    public function setUpdatedAt($updatedAt);
    public function getUpdatedAt();
    
    public function setUpdatedBy($updatedBy);
    public function getUpdatedBy();
    
    public function setUpdatedAs($updatedAs);
    public function getUpdatedAs();
}
