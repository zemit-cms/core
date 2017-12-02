<?php 

namespace Zemit\Mvc\Model\Expose;

class Builder implements BuilderInterface {
    
    protected $_value;
    protected $_field;
    protected $_key;
    protected $_contextKey;
    protected $_parent;
    protected $_expose;
    protected $_columns;
    protected $_protected;
    
    public function getValue() {
        return $this->_value;
    }
    public function setValue($value = null) {
        return $this->_value = $value;
    }
    
    public function getKey() {
        return $this->_key;
    }
    public function setKey($key = null) {
        return $this->_key = (is_string($key) ? trim(mb_strtolower($key)) : null);
    }
    
    public function getContextKey() {
        return $this->_contextKey;
    }
    public function setContextKey($contextKey = null) {
        return $this->_contextKey = $contextKey;
    }
//    public function addContextKey($contextKey = null) {
//        return $this->_contextKey = $this->_contextKey . (empty($this->_contextKey)? $contextKey : (empty($contextKey)? $contextKey : '.' . $contextKey));
//    }
    
    public function getField() {
        return $this->_field;
    }
    public function setField($field = null) {
        return $this->_field = $field;
    }
    
    public function getParent() {
        return $this->_parent;
    }
    public function setParent($parent = null) {
        return $this->_parent = $parent;
    }
    
    public function getExpose() {
        return $this->_expose? true : false;
    }
    public function setExpose($expose = null) {
        return $this->_expose = $expose? true : false;
    }
    
    public function getColumns() {
        return $this->_columns;
    }
    public function setColumns($columns = null) {
        return $this->_columns = $columns;
    }
    
    public function getProtected() {
        return $this->_protected;
    }
    public function setProtected($protected = null) {
        return $this->_protected = $protected;
    }
    
    public function getFullKey() {
        $key = $this->getKey();
        $keyContext = $this->getContextKey();
        return $keyContext . (empty($key) ? null : (empty($keyContext)? $key : '.' . $key));
    }
}