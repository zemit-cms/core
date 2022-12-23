<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Db\Dialect;

/**
 * Class MySQL
 * - Registering custom functions
 * -- Regexp: " %s REGEXP $s"
 * -- Distance:
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Db\Dialect
 */
class Mysql extends \Phalcon\Db\Dialect\Mysql
{
    
    public function __construct()
    {
        $this->registerRegexpFunction();
        $this->registerDistanceSphereFunction();
        $this->registerPointFunction();
    }
    
    /**
     * Register Regexp function
     * @return void
     */
    public function registerRegexpFunction()
    {
        $this->registerCustomFunction('regexp', function ($dialect, $expression) {
            $arguments = $expression['arguments'];
            return sprintf(
                " %s REGEXP %s",
                $dialect->getSqlExpression($arguments[0]),
                $dialect->getSqlExpression($arguments[1])
            );
        });
    }
    
    /**
     * Register ST_Distance_Sphere function
     * @return void
     */
    public function registerDistanceSphereFunction()
    {
        $this->registerCustomFunction('ST_Distance_Sphere', function ($dialect, $expression) {
            $arguments = $expression['arguments'];
            return sprintf(
                " ST_Distance_Sphere(%s, %s)",
                $dialect->getSqlExpression($arguments[0]),
                $dialect->getSqlExpression($arguments[1]),
            );
        });
    }
    
    /**
     * Register ST_Distance_Sphere function
     * @return void
     */
    public function registerPointFunction()
    {
        $this->registerCustomFunction('point', function ($dialect, $expression) {
            $arguments = $expression['arguments'];
            return sprintf(
                " point(%s, %s)",
                $dialect->getSqlExpression($arguments[0]),
                $dialect->getSqlExpression($arguments[1]),
            );
        });
    }
    
}
