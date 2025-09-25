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

use Zemit\Router\RouterInterface;

class Router extends \Phalcon\Cli\Router implements RouterInterface
{
    public function toArray(): array
    {
        $mathedRoute = $this->getMatchedRoute();
        return [
            'module' => $this->getModuleName(),
            'task' => $this->getTaskName(),
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
