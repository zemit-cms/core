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

interface ExportInterface
{
    public function getContentType(?array $params = null): string;
    
    public function getFilename(): string;
    
    public function getExportColumns(array $list): array;
    
    public function export(array $list, ?string $filename = null, ?string $contentType = null, ?array $params = null): bool;
    
    public function exportXml(array $list, ?string $filename = null, ?array $params = null): bool;
    
    public function exportJson(mixed $list, ?string $filename = null, int $flags = JSON_PRETTY_PRINT, int $depth = 2048): bool;
    
    public function exportExcel(array $list, ?string $filename = null): bool;
    
    public function exportCsv(array $list, ?string $filename = null, ?array $params = null): bool;
}
