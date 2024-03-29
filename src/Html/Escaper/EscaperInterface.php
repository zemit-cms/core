<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Html\Escaper;

interface EscaperInterface extends \Phalcon\Html\Escaper\EscaperInterface
{
    public function json(mixed $json = null): string;
}
