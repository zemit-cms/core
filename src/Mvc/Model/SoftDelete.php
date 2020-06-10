<?php

namespace Zemit\Mvc\Model;

use Phalcon\Mvc\Model\Behavior;
use Phalcon\Db\RawValue;

trait SoftDelete {
    
    /**
     * Helper method to check if the row is soft deleted
     * @param null $field
     * @param null $deletedValue
     * @param null $notDeletedValue
     *
     * @return bool|null Bool if we know for sure, null if abnormal
     */
    public function isDeleted($field = null, $deletedValue = null, $notDeletedValue = null) {
        $field ??= self::DELETED_FIELD;
        $deletedValue ??= self::YES;
        $notDeletedValue ??= self::NO;
        
        if (property_exists($this, $field)) {
            if ($this->$field === $deletedValue) {
                return true;
            }
            if ($this->$field === $notDeletedValue) {
                return false;
            }
            
            return null;
        }
        
        return false;
    }
    
    /**
     * Restore a previously Soft-deleted entry
     * @todo add a check from orm.events setup state
     * Events:
     * - beforeRestore
     * - notRestored
     * - afterRestore
     *
     * @param null $field
     * @param null $notDeletedValue
     *
     * @return bool
     */
    public function restore($field = null, $notDeletedValue = null) {
        if (true || ini_get('orm.events')) {
            $this->skipped = false;
            
            // fire event, allowing to stop options or skip the current operation
            if ($this->fireEventCancel('beforeRestore') === false) {
                return false;
            }
            
            if ($this->skipped) {
                return true;
            }
        }
        
        // get settings
        $field ??= self::DELETED_FIELD;
        $notDeletedValue ??= self::NO;
        
        // restore
        $this->assign([$field => $notDeletedValue], [$field]);
        $save = $this->save();
        
        // check if the entity was really restored
        $value = $this->{'get' . ucfirst($field)}() ?? $this->$field;
        $restored = $save && $value === $notDeletedValue;
    
        // fire events
        if (true || ini_get('orm.events')) {
            if (!$restored) {
                $this->fireEvent('notRestored');
            }
            else {
                $this->fireEvent('afterRestore');
            }
        }
        
        return $restored;
    }

}
