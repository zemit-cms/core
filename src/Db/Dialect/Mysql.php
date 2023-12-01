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
 * -- Distance: " ST_Distance_Sphere(%s, %s) "
 * -- point: " point(%s, %s) "
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
     */
    public function registerRegexpFunction(): void
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
     */
    public function registerDistanceSphereFunction(): void
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
     * Register point function
     */
    public function registerPointFunction(): void
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
