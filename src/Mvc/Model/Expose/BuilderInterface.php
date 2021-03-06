<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model\Expose;

interface BuilderInterface
{
    
    public function getValue();
    public function setValue($value = null);
    
    public function getKey();
    public function setKey($key = null);
    
    public function getParent();
    public function setParent($parent = null);
    
    public function getExpose();
    public function setExpose($expose = null);
    
    public function getColumns();
    public function setColumns($columns = null);
    
    public function getContextKey();
    public function setContextKey($contextKey = null);
    
    public function getField();
    public function setField($field = null);
    
    public function getProtected();
    public function setProtected($protected = null);
    
    public function getFullKey();
}
