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
    public const YES = Column::YES;
    public const NO = Column::NO;
    
    public const LANG_EN = 'en';
    public const LANG_FR = 'fr';
    public const LANG_SP = 'sp';
}
