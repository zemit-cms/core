<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit;

/**
 * Class Debug
 * {@inheritDoc}
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit
 */
class Debug extends \Phalcon\Debug
{
    /**
     * {@inheritDoc}
     */
    public function getVersion() : string
    {
        $version = Version::get();
        return
            '<div class="version">'.
                ' Phalcon Framework <a href="https://docs.phalconphp.com/en/'.$version.'/" target="_new">'.\Phalcon\Version::get().'</a>'.
                '&nbsp;&nbsp; – &nbsp;' .
                ' Zemit CMS <a href="https://docs.zemit.com/en/'.$version.'/" target="_new">'.\Zemit\Version::get().'</a>'.
            '</div>'
            ;
    }
}
