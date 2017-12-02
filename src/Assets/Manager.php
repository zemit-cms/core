<?php

namespace Zemit\Assets;

use Phalcon\Assets\Manager as AssetsManager;

class Manager extends AssetsManager {
    
    private $_fileTime;
    private $_version;
    private $_minifyJS;
    private $_minifyCSS;
    
    public function setVersion($version) {
        $this->_version = $version;
    }
    public function getVersion() {
        return $this->_version;
    }
    
    public function setFileTime($fileTime) {
        $this->_fileTime = $fileTime? true : false;
    }
    public function getFileTime() {
        return $this->_fileTime? true : false;
    }
    
    public function setMinifyJS($minifyJS) {
        $this->_minifyJS = $minifyJS? true : false;
    }
    public function getMinifyJS() {
        return $this->_minifyJS? true : false;
    }
    
    public function setMinifyCSS($minifyCSS) {
        $this->_minifyCSS = $minifyCSS? true : false;
    }
    public function getMinifyCSS() {
        return $this->_minifyCSS? true : false;
    }
    
    /**
     * @TODO keep and reset old and keep old old
     * @param type $collectionName
     */
    public function outputJs($collectionName = null) {
        $ressources = $this->get($collectionName)->getResources();
        if ($ressources) {
            foreach ($ressources as $ressource) {
                if ($ressource->getLocal()) {
                    $ressource->setPath(self::_addVersionToPath($ressource->getPath(), $this->getVersion(), $this->getFileTime()));
                }
            }
        }
        parent::outputJs($collectionName);
    }
    
    /**
     * @TODO keep and reset old and keep old old
     * @param type $collectionName
     */
    public function outputCss($collectionName = null) {
        $ressources = $this->get($collectionName)->getResources();
        if ($ressources) {
            foreach ($ressources as $ressource) {
                if ($ressource->getLocal()) {
                    $ressource->setPath(self::_addVersionToPath($ressource->getPath(), $this->getVersion(), $this->getFileTime()));
                }
            }
        }
        parent::outputCss($collectionName);
    }
    
    private static function _addVersionToPath($path, $version, $addFileMTimeToPath = false) {
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
    
    private static function _addFileMtimeToPath($filepath) {
        $path = $filepath;
        if (file_exists($filepath)) {
            $path = explode('.', $filepath);
            $ext = array_pop($path);
            $path = implode('.', $path) . '.' . date('Ymdhis', filemtime($filepath)) . '.' . $ext;
        }
        return $path;
    }
    
}
