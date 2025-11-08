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

namespace PhalconKit\Cli;

use PhalconKit\Router\RouterInterface;

class Router extends \Phalcon\Cli\Router implements RouterInterface
{
    #[\Override]
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
