<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Modules\Cli\Tasks\Traits;

use Phalcon\Db\Adapter\AdapterInterface;
use Phalcon\Db\Column;
use Phalcon\Db\ColumnInterface;
use Zemit\Cli\Dispatcher;
use Zemit\Support\Helper;

/**
 * Trait DescribesTrait
 *
 * This trait provides methods to describe columns, references, and indexes of a database table.
 *
 * @property Dispatcher $dispatcher
 */
trait ScaffoldTrait
{
    // Paths & directories
    protected ?string $namespace = null;
    
    protected string $directory = './';
    protected string $srcDirectory = 'src/';
    protected string $testsDirectory = 'tests/';
    
    protected string $enumsDirectory = 'Enums/';
    protected string $modelsDirectory = 'Models/';
    protected string $abstractsDirectory = 'Abstracts/';
    protected string $interfacesDirectory = 'Interfaces/';
    protected string $controllersDirectory = 'Controllers/';
    
    protected array $whitelistedTables = [];
    protected array $excludedTables = [];
    
    public string $licenseStamp = <<<PHP
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

PHP;
    
    public string $strictTypes = <<<PHP
declare(strict_types=1);

PHP;
    
    /**
     * Retrieves the license stamp.
     * @return string|null The license stamp, or null if there is no license.
     */
    public function getLicenseStamp(): ?string
    {
        return $this->isNoLicense()? '' : $this->dispatcher->getParam('license') ?? $this->licenseStamp;
    }
    
    /**
     * Retrieves the value of the 'strictTypes' property.
     *
     * @return string|null The value of the 'strictTypes' property, or null if the 'no-strict-types' parameter is set.
     */
    public function getStrictTypes(): ?string
    {
        return $this->isNoStrictTypes()? '' : $this->strictTypes;
    }
    
    /**
     * Checks if the given table is whitelisted.
     * @param string $table The table name to check.
     * @return bool Returns true if the table is whitelisted, false otherwise.
     */
    public function isWhitelistedTable(string $table): bool
    {
        if (!isset($this->whitelistedTables)) {
            $this->whitelistedTables = array_filter(explode(',', $this->dispatcher->getParam('table') ?? ''));
        }
        return empty($this->whitelistedTables) || !in_array($table, $this->whitelistedTables);
    }
    
    /**
     * Determines if a table is excluded.
     * @param string $table The name of the table to check.
     * @return bool Returns true if the table is excluded, false otherwise.
     */
    public function isExcludedTable(string $table): bool
    {
        if (!isset($this->excludedTables)) {
            $this->excludedTables = array_filter(explode(',', $this->dispatcher->getParam('table') ?? ''));
        }
        return !empty($this->excludedTables) && in_array($table, $this->excludedTables);
    }
    
    // Method for --no-controllers
    public function isNoControllers(): bool
    {
        return $this->dispatcher->getParameter('noControllers');
    }
    
    // Method for --no-interfaces
    public function isNoInterfaces(): bool
    {
        return $this->dispatcher->getParameter('noInterfaces');
    }
    
    // Method for --no-abstracts
    public function isNoAbstracts(): bool
    {
        return $this->dispatcher->getParameter('noAbstracts');
    }
    
    // Method for --no-models
    public function isNoModels(): bool
    {
        return $this->dispatcher->getParameter('noModels');
    }
    
    // Method for --no-enums
    public function isNoEnums(): bool
    {
        return $this->dispatcher->getParameter('noEnums');
    }
    
    // Method for --no-strict-types
    public function isNoStrictTypes(): bool
    {
        return $this->dispatcher->getParameter('noStrictTypes');
    }
    
    // Method for --no-license
    public function isNoLicense(): bool
    {
        return $this->dispatcher->getParameter('noLicense');
    }
    
    // Method for --no-comments
    public function isNoComments(): bool
    {
        return $this->dispatcher->getParameter('noComments');
    }
    
    // Method for --no-get-set-methods
    public function isNoGetSetMethods(): bool
    {
        return $this->dispatcher->getParameter('noGetSetMethods');
    }
    
    // Method for --no-validations
    public function isNoValidations(): bool
    {
        return $this->dispatcher->getParameter('noValidations');
    }
    
    // Method for --no-relationships
    public function isNoRelationships(): bool
    {
        return $this->dispatcher->getParameter('noRelationships');
    }
    
    // Method for --no-column-map
    public function isNoColumnMap(): bool
    {
        return $this->dispatcher->getParameter('noColumnMap');
    }
    
    // Method for --no-set-source
    public function isNoSetSource(): bool
    {
        return $this->dispatcher->getParameter('noSetSource');
    }
    
    // Method for --no-typings
    public function isNoTypings(): bool
    {
        return $this->dispatcher->getParameter('noTypings');
    }
    
    // Method for --granular-typings
    public function isGranularTypings(): bool
    {
        return $this->dispatcher->getParameter('granularTypings');
    }
    
    // Method for --add-raw-value-type
    public function isAddRawValueType(): bool
    {
        return $this->dispatcher->getParameter('addRawValueType');
    }
    
    // Method for --protected-properties
    public function isProtectedProperties(): bool
    {
        return $this->dispatcher->getParameter('protectedProperties');
    }
    
    /**
     * Determines if a given path is an absolute path.
     * @param string $path The path to be checked. (default: null)
     * @return bool Returns true if the path is an absolute path, false otherwise.
     */
    public function isAbsolutePath(string $path = ''): bool
    {
        return str_starts_with($path, '/');
    }
    
    /**
     * Retrieves the absolute file or directory path.
     *
     * @param string $path The relative or absolute path to the file or directory.
     * @param string $fullPath The full path including directory for the file or directory.
     *
     * @return string The absolute file or directory path. If the given path is absolute, it will be returned as is.
     *                Otherwise, the full path including directory will be returned.
     */
    public function absolutePathOr(string $path = '', string $fullPath = ''): string
    {
        return $this->isAbsolutePath($path)? $path : $fullPath;
    }
    
    /**
     * Retrieves the directory path for a given file or directory path.
     *
     * @param string $path The relative or absolute path to the file or directory.
     *
     * @return string The absolute directory path for the given file or directory path.
     */
    public function getDirectory(string $path = ''): string
    {
        $fullPath = ($this->dispatcher->getParam('directory') ?? $this->directory) . '/' . $path;
        return $this->absolutePathOr($path, $fullPath);
    }
    
    public function getSrcDirectory(string $path = ''): string
    {
        $fullPath = $this->getDirectory($this->dispatcher->getParam('srcDir') ?? $this->srcDirectory) . $path;
        return $this->absolutePathOr($path, $fullPath);
    }
    
    // Tests Directory
    public function getTestsDirectory(string $path = ''): string
    {
        $fullPath = $this->getDirectory($this->dispatcher->getParam('testsDir') ?? $this->testsDirectory) . $path;
        return $this->absolutePathOr($path, $fullPath);
    }
    
    // Controllers Directory
    public function getControllersDirectory(string $path = ''): string
    {
        $fullPath = $this->getSrcDirectory($this->dispatcher->getParam('controllersDir') ?? $this->controllersDirectory) . $path;
        return $this->absolutePathOr($path, $fullPath);
    }
    
    // Models Directory
    public function getModelsDirectory(string $path = ''): string
    {
        $fullPath = $this->getSrcDirectory($this->dispatcher->getParam('modelsDir') ?? $this->modelsDirectory) . $path;
        return $this->absolutePathOr($path, $fullPath);
    }
    
    // Models Interfaces Directory
    public function getModelsInterfacesDirectory(string $path = ''): string
    {
        $fullPath = $this->getModelsDirectory($this->dispatcher->getParam('interfacesDir') ?? $this->interfacesDirectory) . $path;
        return $this->absolutePathOr($path, $fullPath);
    }
    
    // Models Abstracts Directory
    public function getAbstractsDirectory(string $path = ''): string
    {
        $fullPath = $this->getModelsDirectory($this->dispatcher->getParam('abstractsDir') ?? $this->abstractsDirectory) . $path;
        return $this->absolutePathOr($path, $fullPath);
    }
    
    // Models Abstracts Interfaces Directory
    public function getAbstractsInterfacesDirectory(string $path = ''): string
    {
        $fullPath = $this->getAbstractsDirectory($this->dispatcher->getParam('interfaceDir') ?? $this->interfacesDirectory) . $path;
        return $this->absolutePathOr($path, $fullPath);
    }
    
    // Models Tests Directory
    public function getModelsTestsDirectory(string $path = ''): string
    {
        $fullPath = $this->getTestsDirectory($this->dispatcher->getParam('modelsDir') ?? $this->modelsDirectory) . $path;
        return $this->absolutePathOr($path, $fullPath);
    }
    
    /**
     * Converts a file system path to a PHP namespace.
     * @param string $path The file system path to be converted.
     * @return string The converted PHP namespace.
     */
    public function getNamespaceFromPath(string $path): string
    {
        $baseNamespace = ($this->dispatcher->getParam('namespace') ?? $this->namespace);
        $namespace = $baseNamespace . '\\' .
            Helper::camelize(
                Helper::uncamelize(
                    str_replace(
                        '/',
                        '\\',
                        ltrim($path, isset($baseNamespace)? $this->getSrcDirectory() : '')
                    )
                )
            );
        return trim(preg_replace('/\\\\+/', '\\', $namespace), '\\');
    }
    
    // Default namespace
    public function getNamespace(): string
    {
        return $this->getNamespaceFromPath($this->getDirectory());
    }
    
    // Controllers Namespace
    public function getControllersNamespace(): string
    {
        return $this->getNamespaceFromPath($this->getControllersDirectory());
    }
    
    // Models Namespace
    public function getModelsNamespace(): string
    {
        return $this->getNamespaceFromPath($this->getModelsDirectory());
    }
    
    // Abstract Namespace
    public function getAbstractsNamespace(): string
    {
        return $this->getNamespaceFromPath($this->getAbstractsDirectory());
    }
    
    // Models Interfaces Namespace
    public function getModelsInterfacesNamespace(): string
    {
        return $this->getNamespaceFromPath($this->getModelsInterfacesDirectory());
    }
    
    // Models Abstracts Interfaces Namespace
    public function getAbstractsInterfacesNamespace(): string
    {
        return $this->getNamespaceFromPath($this->getAbstractsInterfacesDirectory());
    }
    
    // Models Tests Namespace
    public function getModelsTestsNamespace(): string
    {
        return $this->getNamespaceFromPath($this->getModelsTestsDirectory());
    }
}
