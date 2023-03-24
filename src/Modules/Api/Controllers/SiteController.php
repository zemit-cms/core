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

class SiteController extends Controller
{

    public function getWith(): ?array
    {
        return ['LangList'];
    }
    
    public function getSearchWhiteList(): ?array
    {
        return [
            'id',
            'name',
            'title',
            'description'
        ];
    }
    
    public function getExpose(): ?array
    {
        return [
            'Site' => true
        ];
    }
    
}
