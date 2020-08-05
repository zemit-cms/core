<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\VoltTemplate;

use Phalcon\Di;
use Zemit\Version;

/**
 * Class VoltFunctions
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Provider\VoltTemplate
 */
class VoltFunctions
{
    /**
     * Compile any function call in a template.
     *
     * @param string $name
     * @param mixed $arguments
     *
     * @return null|string
     */
    public function compileFunction($name, $arguments)
    {
        switch($name) {
            case 'join':
                return 'implode(' . $arguments . ')';
        }
        
        return null;
    }
    
    /**
     * Compile some filters.
     *
     * @param string $name The filter name
     * @param mixed $arguments The filter args
     *
     * @return string|null
     */
    public function compileFilter($name, $arguments)
    {
        switch($name) {
            // @todo
        }
        
        return null;
    }
}
