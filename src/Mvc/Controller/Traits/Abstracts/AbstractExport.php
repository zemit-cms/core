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

trait AbstractExport
{
    abstract public function getContentType(?array $params = null): string;
    
    abstract public function getFilename(): string;
    
    abstract public function getExportColumns(array $list): array;
    
    abstract public function export(array $list, ?string $filename = null, string $contentType = null, array $params = null): bool;
    
    abstract public function exportXml(array $list, ?string $filename = null, ?array $params = null): bool;
    
    abstract public function exportJson(mixed $list, ?string $filename = null, int $flags = JSON_PRETTY_PRINT, int $depth = 2048): bool;
    
    abstract public function exportExcel(array $list, ?string $filename = null, bool $forceRawValue = true): bool;
    
    abstract public function exportCsv(array $list, ?string $filename = null, ?array $params = null): bool;
}
