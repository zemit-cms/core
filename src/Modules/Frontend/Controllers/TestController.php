<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Modules\Frontend\Controllers;

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
        '/backend/user/edit' => [
            'for' => 'backend-controller-action',
            'controller' => 'user',
            'action' => 'edit',
        ],
        '/backend/user/edit/1' => [
            'for' => 'backend-controller-action',
            'controller' => 'user',
            'action' => 'edit',
            'params' => 1,
        ],
        '/backend/user/view/1' => [
            'for' => 'backend-controller-action-int',
            'controller' => 'user',
            'action' => 'view',
            'int' => 1,
        ],
        '/backend/user/edit/jturbide' => [
            'for' => 'backend-controller-action',
            'controller' => 'user',
            'action' => 'edit',
            'params' => 'jturbide',
        ],
        '/backend/user/view/jturbide' => [
            'for' => 'backend-controller-action-slug',
            'controller' => 'user',
            'action' => 'view',
            'slug' => 'jturbide',
        ],
        
        '/fr/backend/dashboard' => [
            'for' => 'locale-backend-controller',
            'controller' => 'dashboard',
            'locale' => 'fr',
        ],
    ];
    
    public function indexAction()
    {
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
        die('End of test');
    }
}
