<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Traits\Abstracts;

trait AbstractModel
{
    abstract public function getModelName(): ?string;
    
    abstract public function setModelName(?string $modelName): void;
    
    abstract public function getModelNamespaces(): array;
    
    abstract public function setModelNamespaces(?array $modelNamespaces): void;
    
    abstract public function getModelNameFromController(?array $namespaces = null, string $needle = 'Models'): ?string;
    
    abstract public function getControllerName(): string;
    
    abstract public function loadModel(?string $modelName = null): \Phalcon\Mvc\ModelInterface;
    
    abstract public function appendModelName(string $field, ?string $modelName = null): string;
}
