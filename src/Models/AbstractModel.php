<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Models;

use Zemit\Db\Column;

abstract class AbstractModel extends \Zemit\Mvc\Model
{
    const YES = Column::YES;
    const NO = Column::NO;
}
