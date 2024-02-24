<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Models\Interfaces;

use Phalcon\Mvc\ModelInterface;

interface AbstractInterface extends ModelInterface
{
    public function setId($id);
    public function getId();
    
    public function toArray($columns = null, $useGetter = true): array;
}
