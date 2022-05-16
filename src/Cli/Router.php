<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Cli;

/**
 * Class Router
 * {@inheritDoc}
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Cli
 */
class Router extends \Phalcon\Cli\Router
{
    /**
     * Router toArray
     * @return array
     */
    public function toArray() {
        $mathedRoute = $this->getMatchedRoute();
        return [
            'module' => $this->getModuleName(),
            'action' => $this->getActionName(),
            'params' => $this->getParams(),
            'matches' => $this->getMatches(),
            'matched' => $mathedRoute ? [
                'id' => $mathedRoute->getRouteId(),
                'name' => $mathedRoute->getName(),
                'paths' => $mathedRoute->getPaths(),
                'pattern' => $mathedRoute->getPattern(),
                'reversedPaths' => $mathedRoute->getReversedPaths(),
            ] : null,
        ];
    }
}
