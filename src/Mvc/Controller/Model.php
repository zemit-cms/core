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

trait Model
{
    
    protected $_model = array();
    
    protected function _modelSave($id, $entity = null, $post = array(), $model = null)
    {
        $single = false;
        $reponse = array();
        
        // Get the model name to play with
        $model = empty($model) ? $this->_getModelName() : $model;
        
        // Get the possible post
        $post = empty($post) ? $this->_getPost() : $post;
        
        // Get the possible whitelist
        $whitelist = empty($whitelist) ? $this->_getWhitelist() : $whitelist;
        
        // Check if multi-d post
        if (!empty($id) || !isset($post[0]) || !is_array($post[0])) {
            $single = true;
            $post = array($post);
        }
        
        // Save each posts
        foreach ($post as $key => $singlePost) {
            
            $singlePostEntity = $entity;
            
            // Get the id
            $singlePostId = (!$single || empty($id)) ? $this->_getModelIdFromPostOrParam($singlePost) : $id;
            
            // Get the entity
            $singlePostEntity = (!$single || !isset($entity)) ? $this->_getEntity($singlePostId, $model) : $entity;
            
            // Aucune entité trouvée, créer une nouvelle entité
            if (!$singlePostEntity) {
                $singlePostEntity = new $model();
            }
            
            // Save the entity
            $reponse['save'][$key] = $singlePostEntity->save($singlePost, $whitelist);
            
            // Get the messages from the save request
            $reponse['error'][$key] = $this->_getMessagesFromEntity($singlePostEntity);
            
            // Return the saved entity
            $reponse['model'][$key] = get_class($singlePostEntity);
            $reponse['source'][$key] = $singlePostEntity->getSource();
            $reponse[$singlePostEntity->getSource()][$key] = $singlePostEntity;
            
            // Réponse directement
            if ($single) {
                foreach ($reponse as &$reponseCategorie) {
                    $reponseCategorie = array_pop($reponseCategorie);
                }
            }
        }
        
        // Retourne au format JSON
        return $reponse;
    }
    
    public function _getWhitelist()
    {
        return null;
    }
    
    public function _getEntity($id = null, $name = null)
    {
        
        $id = empty($id) ? $this->_getModelIdFromPostOrParam() : $id;
        $name = empty($name) ? $this->_getModelName() : $name;
        
        if (!empty($id)) {
            $entity = $name::findFirstById((int)$id);
        } else {
            $entity = false;
        }
        return $entity;
    }
    
    public function _getModelName()
    {
        if (!isset($this->_model['name'])) {
            $this->_model['name'] = $this->_getModelNameFromController();
        }
        return $this->_model['name'];
    }
    
    public function _setModelName($name)
    {
        $this->_model['name'] = $name;
    }
    
    public function _getModelNameFromController($controller = null)
    {
        $namespaces = $this->loader->getNamespaces();
        $model = ucfirst(\Phalcon\Text::camelize(\Phalcon\Text::uncamelize((empty($controller) ? $this->dispatcher->getControllerName() : $controller))));
        if (!class_exists($model)) {
            foreach ($namespaces as $namespace => $path) {
                $possibleModel = $namespace . '\\' . $model;
                if (strpos($namespace, 'Models') !== false && class_exists($possibleModel)) {
                    $model = $possibleModel;
                }
            }
        }
        return $model;
    }
    
    public function _getModelIdFromPostOrParam($post = array(), $param = 'id', $defautId = null)
    {
        if (isset($this->_model) && !isset($this->_model['id'])) {
            $post = empty($post) ? $this->_getPost() : $post;
            if (!isset($this->_model['id']) || is_null($this->_model['id'])) {
                $this->_model['id'] = isset($post[$param]) ? $post[$param] : $defautId;
            }
            $this->_model['id'] = $this->dispatcher->getParam($param, 'int', $this->_model['id']);
        }
        
        return isset($this->_model, $this->_model['id']) ? (int)$this->_model['id'] : null;
    }
    
    public function _getMessagesFromEntity($entity)
    {
        $error = array();
        
        // Récupère les messages du model
        $validations = $entity->getMessages();
        
        // Prépare le tableau de retour incluant aussi le type du message
        if ($validations && is_array($validations)) {
            foreach ($validations as $validation) {
                $validationFields = $validation->getField();
                if (!is_array($validationFields)) {
                    $validationFields = array($validationFields);
                }
                foreach ($validationFields as $validationField) {
                    if (empty($error[$validationField])) {
                        $error[$validationField] = array();
                    }
                    $error[$validationField][] = array(
                        'type' => $validation->getType(),
                        'message' => $validation->getMessage()
                    );
                }
            }
        }
        
        // Si au moins une erreur, force un "400 Bad request" dans la réponse HTTP
        if (count($error)) {
            $this->response->setStatusCode(400, 'Bad request');
        }
        
        // Retourne le tableau des messages
        return $error;
    }
    
    protected function _getPost()
    {
        
        // Get assoc array from json raw body
        $post = $this->request->getJsonRawBody(true);
        
        // Get array from $_POST
        if (empty($post)) {
            $post = $this->request->getPost();
        }
        
        // Get array from $_REQUEST
        if (empty($post)) {
            $post = $this->request->get();
        }
        
        return $post;
    }
    
}