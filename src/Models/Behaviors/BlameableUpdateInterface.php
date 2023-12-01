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

interface BlameableUpdateInterface
{
    public function setDeletedAt($deletedAt);
    public function getDeletedAt();
    
    public function setDeletedBy($deletedBy);
    public function getDeletedBy();
    
    public function setDeletedAs($deletedAs);
    public function getDeletedAs();
}
