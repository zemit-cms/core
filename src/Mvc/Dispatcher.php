<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc;

/**
 * @author Julien Turbide <jturbide@nuagerie.com>
 */
class Dispatcher extends \Phalcon\Mvc\Dispatcher
{
    /**
     * Extending forwarding event to prevent cyclic routing when forwarding under dispatcher events
     * - @TODO handle params and other possible route parameters too
     *
     * @param array $route
     * {@inheritDoc}
     */
    public function forward(array $forward, $preventCycle = false): void {
        if (!$preventCycle) {
            parent::forward($forward);
        } else {
            if (
                (!isset($forward['namespace']) || $this->getNamespaceName() !== $forward['namespace']) &&
                (!isset($forward['module']) || $this->getModuleName() !== $forward['module']) &&
                (!isset($forward['controller']) || $this->getControllerName() !== $forward['controller']) &&
                (!isset($forward['action']) || $this->getActionName() !== $forward['action']) &&
                (!isset($forward['params']) || $this->getParams() !== $forward['params']) &&
                true
            ) {
                if (!isset($forward['namespace'])) {
                    unset($forward['namespace']);
                }
                if (!isset($forward['module'])) {
                    unset($forward['module']);
                }
                if (!isset($forward['controller'])) {
                    unset($forward['controller']);
                }
                if (!isset($forward['action'])) {
                    unset($forward['action']);
                }
                if (!isset($forward['params'])) {
                    unset($forward['params']);
                }
                $this->forward($forward);
            }
        }
    }
}
