<?php

namespace Zemit\Mvc\Controller;

/**
 * @author Julien Turbide <Zemit@nuagerie.com>
 * @version 1.0.0
 */
class Rest extends \Phalcon\Mvc\Controller {
    
    protected $_response;
    
    use Model;
    
    public function indexAction() {
        $this->_prepareRest();
    }
    
    protected function _prepareRest() {
        
        $id = $this->_getModelIdFromPostOrParam();

        // Ajoute ou met à jour une entité
        if ($this->request->isPost() || $this->request->isPut()) {

            $this->dispatcher->forward(array(
                'action' => 'save'
            ));
        }

        // Supprime une entité
        else if ($this->request->isDelete()) {
            
            $this->dispatcher->forward(array(
                'action' => 'delete'
            ));
        }

        // Récupère une ou toute les entités
        else if ($this->request->isGet()) {

            if (is_null($id)) {
                
                $this->dispatcher->forward(array(
                    'action' => 'getAll'
                ));
            }
            else {
                
                $this->dispatcher->forward(array(
                    'action' => 'get'
                ));
            }
            
        }
        
        // @TODO voir quoi faire avec les request options
        else if ($this->request->isOptions()) {
            return array('result' => 'OK');
        }
    }
    
    public function getAction($id = null) {
        return $this->_getEntity($id);
    }
    
    public function getAllAction() {
        $model = $this->_getModelNameFromController();
        return $model::find();
    }
    
    public function saveAction($id = null) {
        return $this->_modelSave($id);
    }
    
    public function deleteAction($id = null) {
        $response = array();
        $entity = $this->_getEntity($id);
        $response['model'] = $entity;
        if ($entity) {
            $response['delete'] = $entity->delete();
            $response['error'] = $this->_getMessagesFromEntity($entity);
            $response['source'] = $entity->getSource();
        }
        return $response;
    }
}