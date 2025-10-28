<?php

declare(strict_types=1);

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Support;

/**
 * This class allows to get the installed version of the zemit core
 */
class Version extends \Phalcon\Support\Version
{
    /**
     * Area where the version number is set. The format is as follows:
     * ABBCCDE
     *
     * A - Major version
     * B - Med version (two digits)
     * C - Min version (two digits)
     * D - Special release: 1 = Alpha, 2 = Beta, 3 = RC, 4 = Stable
     * E - Special release version i.e. RC1, Beta2 etc.
     *
     * @return array{int, int, int, int, int}
     */
    #[\Override]
    protected function getVersion(): array
    {
        return [1, 1, 0, 4, 0];
    }
}
