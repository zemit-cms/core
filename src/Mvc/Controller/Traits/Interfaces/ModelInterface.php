<?php

declare(strict_types=1);

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Traits\Interfaces;

interface ModelInterface
{
    public function getModelName(): ?string;
    
    public function setModelName(?string $modelName = null): void;
    
    public function getModelNamespaces(): array;
    
    public function setModelNamespaces(?array $modelNamespaces = []): void;
    
    public function getModelNameFromController(?array $namespaces = null, string $needle = 'Models'): ?string;
    
    public function getControllerName(): string;
    
    public function loadModel(?string $modelName = null): \Phalcon\Mvc\ModelInterface;
}
