<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Modules\Api\Controllers;

use Zemit\Modules\Api\Controller;
use Zemit\Mvc\Model\Expose\Builder;

/**
 * Class SiteController
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Modules\Api\Controllers
 */
class SiteController extends Controller
{

    public function getWith()
    {
        return ['LangList'];
    }
    
    public function getSearchWhiteList()
    {
        return [
            'id',
            'name',
            'title',
            'description'
        ];
    }
    
    public function getExpose()
    {
        return [
            'Site' => true
        ];
    }
    
}
