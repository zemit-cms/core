<?php

declare(strict_types=1);

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit Team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace PhalconKit\Models;

use PhalconKit\Db\Column;

abstract class AbstractModel extends \PhalconKit\Mvc\Model
{
    public const int YES = Column::YES;
    public const int NO = Column::NO;
    
    public const string LANG_EN = 'en';
    public const string LANG_FR = 'fr';
    public const string LANG_SP = 'sp';
}
