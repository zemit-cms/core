<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Models\Behaviors\Blameable;

interface RestoredInterface
{
    public function setRestoredAt($restoredAt);
    public function getRestoredAt();
    
    public function setRestoredBy($restoredBy);
    public function getRestoredBy();
    
    public function setRestoredAs($restoredAs);
    public function getRestoredAs();
}
