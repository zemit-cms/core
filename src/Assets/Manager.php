<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Assets;

use Phalcon\Assets\Collection;

/**
 * Class Manager
 * {@inheritDoc}
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Assets
 */
class Manager extends \Phalcon\Assets\Manager
{
    /**
     * Version of your app (ex. 1.0.0)
     * @var string Set the version to be added in the asset path
     */
    protected string $version;
    
    /**
     *
     * @var bool true to automatically add the file time to the asset path
     */
    protected bool $fileTime;
    
    /**
     * Minify Javascript
     * @var bool true automatically minify javascript files
     */
    protected bool $minifyJS;
    
    /**
     * Minify CSS
     * @var bool true automatically minify stylesheet files
     */
    protected bool $minifyCSS;
    
    /**
     * Force the version manually
     * Version will be added to the assets path
     *
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }
    
    /**
     * Get the version if forced
     * @return string Version
     */
    public function getVersion()
    {
        return $this->version;
    }
    
    /**
     * Set File Time
     * @param $fileTime True to enable
     */
    public function setFileTime(bool $fileTime) : void
    {
        $this->fileTime = $fileTime ? true : false;
    }
    
    /**
     * Get File Time
     * @return bool True if enabled
     */
    public function getFileTime()
    {
        return $this->fileTime ? true : false;
    }
    
    /**
     * Set minify JS
     * @todo to be removed
     * @deprecated You should use webpack or something else
     * @param $minifyJS True to enable
     */
    public function setMinifyJS(bool $minifyJS) : void
    {
        $this->minifyJS = $minifyJS ? true : false;
    }
    
    /**
     * @return bool
     * @todo to be removed
     * @deprecated You should use webpack or something else
     */
    public function getMinifyJS() : bool
    {
        return $this->minifyJS ? true : false;
    }
    
    /**
     * @todo to be removed
     * @deprecated You should use webpack or something else
     * @param $minifyCSS
     */
    public function setMinifyCSS(bool $minifyCSS) : void
    {
        $this->minifyCSS = $minifyCSS ? true : false;
    }
    
    /**
     * @todo to be removed
     * @deprecated You should use webpack or something else
     * @return bool
     */
    public function getMinifyCSS() : bool
    {
        return $this->minifyCSS ? true : false;
    }
    
    /**
     * @param string|null $collectionName
     *
     * @return string
     */
    public function outputJs(?string $collectionName = 'js'): string
    {
        $this->setCollectionVersion($collectionName);
        
        return parent::outputJs($collectionName);
    }
    
    /**
     * @param null $collectionName
     *
     * @return string|null
     */
    public function outputCss($collectionName = 'css'): string
    {
        $this->setCollectionVersion($collectionName);
        
        return parent::outputCss($collectionName);
    }
    
    /**
     * Add version to the collection
     *
     * @param string|null $collectionName
     *
     * @return Collection
     */
    public function setCollectionVersion(?string $collectionName = null): Collection
    {
        $collection = $this->exists($collectionName) ? $this->get($collectionName) : false;
        if ($collection) {
            $collection = $this->get($collectionName);
            if ($collection) {
                $version = $this->getVersion();
                if (empty($version)) {
                    $collection->setVersion($version);
                }
                else {
                    $collection->setAutoVersion(true);
                }
            }
        }
        
        return $collection;
    }
    
    /**
     * Add version to a path
     *
     * @todo to be removed or check if phalcon team implemented it according to our needs
     * @deprecated Now natively supported by phalcon asset collection itself
     *
     * @param $path
     * @param $version
     * @param false $addFileMTimeToPath
     *
     * @return string
     */
    private static function _addVersionToPath($path, $version, $addFileMTimeToPath = false)
    {
        if ($addFileMTimeToPath) {
            $path = self::_addFileMtimeToPath($path);
        }
        if (!empty($version)) {
            $path = explode('.', $path);
            $ext = array_pop($path);
            $path = implode('.', $path) . '.' . $version . '.' . $ext;
        }
        
        return $path;
    }
    
    /**
     * Add File Mime Time to the path
     *
     * @deprecated
     *
     * @param $filepath
     *
     * @return string
     */
    private static function _addFileMtimeToPath(string $filepath)
    {
        $path = $filepath;
        if (file_exists($filepath)) {
            $path = explode('.', $filepath);
            $ext = array_pop($path);
            $path = implode('.', $path) . '.' . date('Ymdhis', filemtime($filepath)) . '.' . $ext;
        }
        
        return $path;
    }
}
