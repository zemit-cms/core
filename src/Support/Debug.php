<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Support;

use Zemit\Support\Version as ZemitVersion;
use Phalcon\Support\Version as PhalconVersion;

/**
 * {@inheritDoc}
 */
class Debug extends \Phalcon\Support\Debug
{
    /**
     * {@inheritDoc}
     */
    public function getVersion(): string
    {
        $zemitVersion = new ZemitVersion();
        $phalconVersion = new PhalconVersion();
        return
            '<div class="version">' .
                ' Zemit Core <a href="https://docs.zemit.com/" target="_new">' . $zemitVersion->get() . '</a>' .
                '&nbsp;-&nbsp;' .
                'Phalcon Framework <a href="https://docs.phalcon.io/' . PhalconVersion::VERSION_MAJOR . '.0/en/" target="_new">' . $phalconVersion->get() . '</a>' .
            '</div>'
            ;
    }
}
