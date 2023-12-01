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

interface BlameableCreateInterface
{
    public function setCreatedAt($createdAt);
    public function getCreatedAt();
    
    public function setCreatedBy($createdBy);
    public function getCreatedBy();
    
    public function setCreatedAs($createdAs);
    public function getCreatedAs();
}
