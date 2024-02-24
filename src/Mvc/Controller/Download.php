<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller;

use Exception;
use League\Csv\ByteSequence;
use League\Csv\CannotInsertRecord;
use League\Csv\CharsetConverter;
use League\Csv\InvalidArgument;
use League\Csv\Writer;
use Shuchkin\SimpleXLSXGen;
use Zemit\Support\Slug;

trait Download {
    
    use Params;
    
    /**
     * Get the content type based on the given parameters.
     *
     * @param array|null $params Optional. The parameters to determine the content type. If not provided, it will use the default parameters.
     * @return string The content type. Possible values: "json", "csv", "xlsx".
     * @throws Exception When an unsupported content type is provided.
     */
    public function getContentType(?array $params = null): string
    {
        $params ??= $this->getParams();
        
        $contentType = strtolower($params['contentType'] ?? $params['content-type'] ?? $this->request->getContentType() ?? '');
        
        switch ($contentType) {
            case 'html':
            case 'text/html':
            case 'application/html':
                // html not supported yet
                break;
            
            case 'xml':
            case 'text/xml':
            case 'application/xml':
                // xml not supported yet
                break;
            
            case 'text':
            case 'text/plain':
                // plain text not supported yet
                break;
            
            case 'json':
            case 'text/json':
            case 'application/json':
                return 'json';
            
            case 'csv':
            case 'text/csv':
                return 'csv';
            
            case 'xlsx':
            case 'application/xlsx':
            case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                return 'xlsx';
            
            case 'xls':
            case 'application/vnd.ms-excel':
                // old xls not supported yet
                break;
        }
        
        throw new Exception('`' . $contentType . '` is not supported.', 400);
    }
    
    /**
     * Download a JSON / CSV / XLSX
     * @TODO optimize this using stream and avoid storage large dataset into variables
     * @throws CannotInsertRecord
     * @throws InvalidArgument
     * @throws \League\Csv\Exception
     * @throws Exception
     */
    public function download(array $list = [], string $fileName = null, string $contentType = null, array $params = null): bool
    {
        $params ??= $this->getParams();
        $contentType ??= $this->getContentType();
        $fileName ??= ucfirst(Slug::generate(basename(str_replace('\\', '/', $this->getModelClassName())))) . ' List (' . date('Y-m-d') . ')';
        
        if ($contentType === 'json') {
//            $this->response->setJsonContent($list);
            $this->response->setContent(json_encode($list, JSON_PRETTY_PRINT, 2048));
            $this->response->setContentType('application/json');
            $this->response->setHeader('Content-disposition', 'attachment; filename="' . addslashes($fileName) . '.json"');
            $this->response->send();
            return true;
        }
        
        $listColumns = [];
        if ($contentType === 'csv' || $contentType === 'xlsx') {
            foreach ($list as $row) {
                foreach (array_keys($row) as $key) {
                    $listColumns[$key] = true;
                }
            }
        }
        $listColumns = array_keys($listColumns);
        
        // CSV
        if ($contentType === 'csv') {
            
            // Get CSV custom request parameters
            $mode = $params['mode'] ?? null;
            $delimiter = $params['delimiter'] ?? null;
            $enclosure = $params['enclosure'] ?? null;
            $endOfLine = $params['endOfLine'] ?? null;
            $escape = $params['escape'] ?? '';
            $outputBOM = $params['outputBOM'] ?? null;
            $skipIncludeBOM = $params['skipIncludeBOM'] ?? false;
            $relaxEnclosure = $params['relaxEnclosure'] ?? false;
            $keepEndOfLines = $params['keepEndOfLines'] ?? false;

//            $csv = Writer::createFromFileObject(new \SplTempFileObject());
            $csv = Writer::createFromStream(fopen('php://memory', 'r+'));
            
            // CSV - MS Excel on MacOS
            if ($mode === 'mac') {
                $csv->setOutputBOM(ByteSequence::BOM_UTF16_LE); // utf-16
                $csv->setDelimiter("\t"); // tabs separated
                $csv->setEndOfLine("\r\n"); // end of lines
                CharsetConverter::addTo($csv, 'UTF-8', 'UTF-16');
            }
            
            // CSV - MS Excel on Windows
            else {
                $csv->setOutputBOM(ByteSequence::BOM_UTF8); // utf-8
                $csv->setDelimiter(','); // comma separated
                $csv->setEndOfLine("\r\n"); // end of lines
                CharsetConverter::addTo($csv, 'UTF-8', 'UTF-8');
            }
            
            // relax enclosure
            if ($relaxEnclosure) {
                $csv->relaxEnclosure();
            }
            // force enclosure
            else {
                $csv->forceEnclosure();
            }
            // set enclosure
            if (isset($enclosure)) {
                $csv->setEnclosure($enclosure);
            }
            // set output bom
            if (isset($outputBOM)) {
                $csv->setOutputBOM($outputBOM);
            }
            // set delimiter
            if (isset($delimiter)) {
                $csv->setDelimiter($delimiter);
            }
            // send end of line
            if (isset($endOfLine)) {
                $csv->setEndOfLine($endOfLine);
            }
            // set escape
            if (isset($escape)) {
                $csv->setEscape($escape);
            }
            // skip include bom
            if ($skipIncludeBOM) {
                $csv->skipInputBOM();
            }
            // include bom
            else {
                $csv->includeInputBOM();
            }
            
            // Headers
            $csv->insertOne($listColumns);
            
            foreach ($list as $row) {
                $outputRow = [];
                foreach ($listColumns as $column) {
                    $outputRow[$column] = $row[$column] ?? '';
                    
                    // sometimes excel can't process the cells multiple lines correctly when loading csv
                    // this is why we remove the new lines by default, user can choose to keep them using $keepEndOfLines
                    if (!$keepEndOfLines && is_string($outputRow[$column])) {
                        $outputRow[$column] = trim(preg_replace('/\s+/', ' ', $outputRow[$column]));
                    }
                }
                $csv->insertOne($outputRow);
            }
            
            // CSV
            $csv->output($fileName . '.csv');
            return true;
        }
        
        // XLSX
        if ($contentType === 'xlsx') {
            $xlsxArray = [];
            $xlsxArray [] = $listColumns;
            
            foreach ($list as $row) {
                $outputRow = [];
                foreach ($listColumns as $column) {
                    $outputRow[$column] = $row[$column] ?? '';
                }
                $xlsxArray [] = array_values($outputRow);
            }
            
            $xlsx = SimpleXLSXGen::fromArray($xlsxArray);
            return $xlsx->downloadAs($fileName . '.xlsx');
        }
        
        // Something went wrong
        throw new Exception('Failed to export `' . $this->getModelClassName() . '` using content-type `' . $contentType . '`', 400);
    }
}
