<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Dispatcher;

use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\User\Component;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Resultset;
use Phalcon\Mvc\View;

class Rest extends Component {

    private $_response = array();
    
    public function getId(Dispatcher $dispatcher) {
        $restPrimaryKey = isset($this->config->rest->primary_key)? $this->config->rest->primary_key : 'id';
        $id = $dispatcher->getParam($restPrimaryKey);
        if (empty($id)) {
            $params = $dispatcher->getParams();
            $id = isset($params[0])? $params[0] : null;
        }
        return $id;
    }

    public function beforeDispatch(Event $event, Dispatcher $dispatcher, $exception) {
        $controllerName = ucfirst(\Phalcon\Text::camelize(\Phalcon\Text::uncamelize($dispatcher->getControllerClass())));
        $actionName = lcfirst(\Phalcon\Text::camelize(\Phalcon\Text::uncamelize($dispatcher->getActiveMethod())));

        try {
            $reflection = new \ReflectionMethod($controllerName, $actionName);
            foreach ($reflection->getParameters() as $parameter) {

                $possibleClass = $parameter->getClass();
                
                $className = null;
                if (empty($possibleClass) && $parameter->isArray()) {
                    $className = \ArrayObject::class;
                }
                if (empty($className) && $possibleClass && !empty($possibleClass->name)) {
                    $className = $possibleClass->name;
                }
                
//                var_dump($className);
                
                if ($className) {
                    
                    if (is_subclass_of($className, Model::class) || is_subclass_of($className, Resultset::class) || $className === \ArrayObject::class || $className === \stdClass::class) {
                        

                        $propertyName = $parameter->name;
                        if (is_callable(array($controllerName, '_restSetup'))) {
                            $rest = $controllerName::_restSetup($this, $event, $dispatcher, $exception);
                        } else {
                            $rest = array();
                        }

                        $models = null;
                        if ($rest) {
                            if (isset($rest[$propertyName])) {
                                $propertyParams = $rest[$propertyName];
                                foreach ($propertyParams as $modelName => $methods) {
                                    if (is_subclass_of($className, Resultset::class) || $className === \ArrayObject::class || $className === \stdClass::class) {
                                        $className = $modelName;
                                        if (strpos('\\', $className)) {
                                            $className = '\\' . $className;
                                        }
                                    }
                                    if ($modelName === $className || $modelName === basename($className)) {
                                        foreach ($methods as $method => $params) {
                                            $filter = $this->filter;
                                            $paramsToEval = function($key) use ($params, $filter) {
                                                return '$params[' . (is_int($key)? $filter->sanitize($key, 'int') : '\'' . $key . '\'') . ']';
                                            };
                                            $paramStringVars = implode(', ', array_map($paramsToEval, array_unique(array_keys($params))));
                                            
                                            $toEval = '$models = $className::$method(' . $paramStringVars . ');';
                                            eval($toEval);
                                            
                                            // The first request success win, this allow fallbacks with multiple requests
//                                            if ($models) {
//                                                break;
//                                            }
                                            if (is_callable(array($controllerName, '_restSetup'))) {
                                                $rest = $controllerName::_restSetup($this, $event, $dispatcher, $exception);
                                            } else {
                                                $rest = array();
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        
                        if (!$models && (!$rest || !isset($rest[$propertyName]))) {
                            if (basename(str_replace('\\', '/', ($className))) === basename(str_replace(array('\\', 'Controller'), array('/', null), $controllerName))) {
                                $id = $this->getId($dispatcher);
                                $models = $className::findFirstById($this->filter->sanitize($id, 'int'));
                            }
                        }
                        $dispatcher->setParam($parameter->name, $models ? $models : null);
                    }
                }
            }
        } catch (\Exception $e) {
            $dispatcher->getEventsManager()->fire('dispatch:beforeException', $dispatcher, $e);
        }
    }

    public static function getParametersFromRestProperty($property) {
        return $property;
    }

    public function afterDispatch(Event $event, Dispatcher $dispatcher) {
        $controller = $dispatcher->getActiveController();
        $defaultContent = isset($this->_response) ? $this->_response : array();
        $response = array_merge_recursive($defaultContent, array(
            'response' => $dispatcher->getReturnedValue(),
        ));
        
        $response['profiler'] = $this->_getSQLProfiles();
        if ($response['response']) {
            $this->_response = $response;
        }
        
        // Si error, forcer le code 400 Bad request
        if (is_array($response['response']) && !empty($response['response']['error'])) {
            $controller->response->setStatusCode(400, 'Bad request');
        }
        
        if (isset($response['response'])) {
            $controller->view->disableLevel(array(
                View::LEVEL_ACTION_VIEW => true,
                View::LEVEL_LAYOUT => true,
                View::LEVEL_MAIN_LAYOUT => true,
                View::LEVEL_AFTER_TEMPLATE => true,
                View::LEVEL_BEFORE_TEMPLATE => true
            ));
            $controller->response->setContentType('application/json', 'UTF-8')->setJsonContent($response);
            if ($response['response'] !== false) {
                $controller->response->send();
                return false;
            }
        }
    }

    private function _getSQLProfiles() {
        $ret = false;
        
        // activate the profiler by default if not config
        if (!isset($this->config->app->profiler) || $this->config->app->profiler) {
            
            // prepare our profiles response as the profiler is activated
            $profiles = array();
            
            // make sure the profile is active
            if ($this->profiler) {
                
                // get our profiles
                $profilerProfiles = $this->profiler->getProfiles();
                if ($profilerProfiles) {
                    foreach ($profilerProfiles as $profile) {
                        $profiles [] = array(
                            'statement' => $profile->getSqlStatement(),
                            'init' => $profile->getInitialTime(),
                            'final' => $profile->getFinalTime(),
                            'elapsed' => $profile->getTotalElapsedSeconds(),
                        );
                    }
                }
                
                // setup the profiler object to return
                $ret = array(
                    'profiles' => $profiles,
                    'statements' => $this->profiler->getNumberTotalStatements(),
                    'elapsed' => $this->profiler->getTotalElapsedSeconds(),
                );
            }
        }
        
        // return false, profiler config off
        return $ret;
    }

}
