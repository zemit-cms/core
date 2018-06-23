<?php

namespace Zemit\Core\Frontend\Controllers;

class TestController extends AbstractController
{
    public $testUrls = [
        '/backend' => [
            'for' => 'backend',
        ],
        '/backend/dashboard' => [
            'for' => 'backend-controller',
            'controller' => 'dashboard',
        ],
        '/fr/backend/dashboard' => [
            'for' => 'locale-backend-controller',
            'controller' => 'dashboard',
            'locale' => 'fr',
        ],
    ];
    
    public function indexAction() {
        foreach ($this->testUrls as $url => $array) {
            $result = $this->url->get($array);
            if ($result !== $url) {
                print_r([
                    'route' => 'WRONG URL GET - ' . $url,
                    'expect' => $url,
                    'result' => $result,
                    'array' => $array,
                ]);
            }
        }
        die();
    }
}