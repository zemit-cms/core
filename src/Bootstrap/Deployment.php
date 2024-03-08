<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Bootstrap;

use Phalcon\Config\Config as PhalconConfig;
use Zemit\Models\Lang;
use Zemit\Models\Role;
use Zemit\Models\Setting;
use Zemit\Models\Template;
use Zemit\Models\User;
use Zemit\Models\UserRole;
use Zemit\Models\Workspace;

/**
 * Zemit Deployment Configuration
 *
 * @property PhalconConfig $drop
 * @property PhalconConfig $truncate
 * @property PhalconConfig $engine
 * @property PhalconConfig $insert
 */
class Deployment extends \Zemit\Config\Config
{
    public function __construct(array $data = [], bool $insensitive = true)
    {
        $data = $this->internalMergeAppend([
            /**
             * Tables to drop
             */
            'drop' => [],
            
            /**
             * Tables to truncate
             */
            'truncate' => [
                'audit',
                'audit_detail',
                'category',
                'table',
                'data',
                'email',
                'email_file',
                'field',
                'file',
                'file_relation',
                'flag',
                'group',
                'group_role',
                'group_type',
                'lang',
                'log',
                'menu',
                'meta',
                'page',
                'phalcon_migrations',
                'post',
                'post_category',
                'role',
                'session',
                'setting',
                'workspace',
                'workspace_lang',
                'template',
                'translate',
                'translate_field',
                'translate_table',
                'type',
                'user',
                'user_group',
                'user_role',
                'user_type',
                'validator',
            ],
            
            /**
             * Table engines
             */
            'engine' => [
                'audit' => 'InnoDB',
                'audit_detail' => 'InnoDB',
                'category' => 'InnoDB',
                'table' => 'InnoDB',
                'data' => 'InnoDB',
                'email' => 'InnoDB',
                'email_file' => 'InnoDB',
                'field' => 'InnoDB',
                'file' => 'InnoDB',
                'file_relation' => 'InnoDB',
                'flag' => 'InnoDB',
                'group' => 'InnoDB',
                'group_role' => 'InnoDB',
                'group_type' => 'InnoDB',
                'lang' => 'InnoDB',
                'log' => 'InnoDB',
                'menu' => 'InnoDB',
                'meta' => 'InnoDB',
                'page' => 'InnoDB',
                'phalcon_migrations' => 'InnoDB',
                'post' => 'InnoDB',
                'post_category' => 'InnoDB',
                'role' => 'InnoDB',
                'session' => 'InnoDB',
                'setting' => 'InnoDB',
                'workspace' => 'InnoDB',
                'workspace_lang' => 'InnoDB',
                'template' => 'InnoDB',
                'translate' => 'InnoDB',
                'translate_field' => 'InnoDB',
                'translate_table' => 'InnoDB',
                'type' => 'InnoDB',
                'user' => 'InnoDB',
                'user_group' => 'InnoDB',
                'user_role' => 'InnoDB',
                'user_type' => 'InnoDB',
                'validator' => 'InnoDB',
            ],
            
            /**
             * Insert records
             */
            'insert' => [
                UserRole::class => [],
                Role::class => [
                    ['index' => 'dev', 'label' => 'Developer'],
                    ['index' => 'admin', 'label' => 'Administrator'],
                    ['index' => 'user', 'label' => 'User'],
                    ['index' => 'guest', 'label' => 'Guest'],
                    ['index' => 'everyone', 'label' => 'Everyone'],
                ],
                User::class => [
                    ['username' => 'dev', 'email' => 'dev@zemit.com', 'firstName' => 'Developer', 'lastName' => 'Zemit', 'rolelist' => [1]],
                ],
                Lang::class => [
                    ['label' => 'Francais', 'code' => 'fr'],
                    ['label' => 'English', 'code' => 'en'],
                    ['label' => 'Spanish', 'code' => 'sp'],
                ],
                Workspace::class => [
                    ['name' => 'Zemit CMS', 'title' => 'Zemit CMS', 'description' => ''],
                ],
                Template::class => [
                ],
                Setting::class => [
                ],
            ],
        ], $data);
        
        parent::__construct($data, $insensitive);
    }
}
