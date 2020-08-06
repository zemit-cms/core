<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model;

use Phalcon\Text;
use Phalcon\Db\Column;

/**
 * Trait Log
 * @deprecated please use AuditBehavior instead
 * @todo to be removed
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Mvc\Model
 */
trait Log
{
    
    public static $_staticLog = array();
    
    /**
     * Log system init
     */
    protected function _setLog($namespace = __NAMESPACE__, $table = 'log', $user_id_field = 'user_id')
    {
        self::$_staticLog['namespace'] = $namespace;
        self::$_staticLog['table'] = $table;
        self::$_staticLog['user_id_field'] = $user_id_field;
        self::$_staticLog['class'] = (empty(self::$_staticLog['namespace'])? null : self::$_staticLog['namespace'] . '\\') .
            ucfirst(Text::camelize(Text::uncamelize(self::$_staticLog['table'])));
        
        if ($this->getSource() !== $table) {
            $this->getEventsManager()->attach('model', function ($event, $entity) use ($namespace, $table) {
                if ($entity->getSource() !== $table) {
                    switch ($event->getType()) {
                        case 'beforeDelete':
                            $entityLog = $entity->_setLogBefore();
                            $entityLog->after = null;
                            if (!$entityLog->save()) {
                                return false;
                            }
                            break;
                        case 'afterValidation':
                            // fix for the "already" deleted related tables and nodes
                            // @TODO refaire le fix sans refaire de fetch à la BD
                            $classPath = $namespace . '\\' . ucfirst(Text::camelize(Text::uncamelize($entity->getSource())));
                            $refetched = $classPath::findFirstById($entity->id);
//
                            if ($refetched) {
                                if ($entity->hasChanged()) {
                                    // Ne pas changer le save pour un validate parce qu'on veut aussi les throw exception
                                    // si par exemple le not null validation est à true et qu'on a pas fait la validation du not null
                                    // dans le validateur, permet aussi de s'assurer que le log sera bien fait avant de sauvegarder l'entité
                                    $entity->_setLogBefore();
                                    $log = $entity->_setLogAfter();
                                    
//                                    var_dump($log->before);
//                                    var_dump($log->after);
                                        
                                    if (!$log->save()) {
                                        return false;
                                    }
                                }
                            }
                            break;
                        case 'afterCreate':
                            // Save it after save if we now have a entity id
                            // @TODO we need to track this save error because its afterCreate
                            $entity->_setLogAfter()->save();
                            break;
                        case 'afterDelete':
                            // Pour si on delete il faut clearer le résultat car l'entité possède encore les datas
                            if ($entity->hasChanged()) {
                                $entityLog = $entity->_getLog();
                                $entityLog->after = null;
                                $entityLog->save();
                            }
                            break;
                    }
                }
                return true;
            });
        }
    }
    
    protected function _prepareLog(&$log = null)
    {
        $logClass = self::$_staticLog['class'];
        if (class_exists($logClass)) {
            $log = $log? $log : new $logClass();
            $userIdField = self::$_staticLog['user_id_field'];
            if (method_exists($this, '_getUser') && property_exists($log, $userIdField)) {
                if (empty($log->$userIdField)) {
                    $user = $log->_getUser();
                    if ($user) {
                        $log->$userIdField = $user->id;
                    }
                }
            }
            
            if (empty($log->table)) {
                $log->table = $this->getSource();
            }
            if (empty($log->table_id) && !empty($this->id)) {
                $log->table_id = $this->id;
            }
        }
        return $log;
    }
    
    /**
     *
     * @return Log
     */
    protected function _getLog()
    {
        if (!isset(self::$_staticLog['log'])) {
            return self::$_staticLog['log'] = $this->_prepareLog();
        } else {
            return $this->_prepareLog(self::$_staticLog['log']);
        }
    }
    
    protected function _setLogBefore()
    {
        $log = $this->_getLog();
        if ($this->hasSnapshotData()) {
            $log->before = $this->getSnapshotData();
        } else {
            $log->before = $this;
        }
        return $log;
    }
    
    protected function _setLogAfter()
    {
        $log = $this->_getLog();
        $log->after = $this;
        return $log;
    }
    
    public function getMessages($filter = null)
    {
        if ($this->getSource() !== self::$_staticLog['table']) {
            $log = $this->_getLog();
            $logMessages = $log ? $log->getMessages($filter) : array();
            if ($logMessages) {
                foreach ($logMessages as $logMessage) {
                    $this->appendMessage($logMessage);
                }
            }
        }
        return parent::getMessages($filter);
    }
    
    public function getLogsByTable($table = null, $arguments = null)
    {
        $defaultCondition = 'table = :table: and table_id = :tableId:';
        $argumentsArray = empty($arguments)? array() : (is_string($arguments)? array($defaultCondition . ' and (' . $arguments . ')') : $arguments);
        $logClass = self::$_staticLog['class'];
        return $logClass::find(array_replace_recursive(array(
            $defaultCondition,
            'bind' => array(
                'table' => empty($table)? $this->getSource() : $table,
                'tableId' => (int) $this->getDI()->get('filter')->sanitize($this->id, 'int')
            ),
            'bindTypes' => array(
                'table' => Column::BIND_PARAM_STR,
                'tableId' => Column::BIND_PARAM_INT
            ),
        ), $argumentsArray));
    }
}
