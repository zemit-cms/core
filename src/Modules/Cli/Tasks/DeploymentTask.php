<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Modules\Cli\Tasks;

use Phalcon\Db\Adapter\Pdo\Mysql;
use Zemit\Models\Lang;
use Zemit\Models\Site;
use Zemit\Models\UserRole;
use Zemit\Modules\Cli\Task;
use Zemit\Models\Role;
use Zemit\Models\User;
use Zemit\Models\Setting;
use Zemit\Models\Template;
use Zemit\Utils;

/**
 * Class DeploymentTask
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Modules\Cli\Tasks
 */
class DeploymentTask extends Task
{
    /**
     * @var string
     */
    public $consoleDoc = <<<DOC
Usage:
  php zemit cli deployment <action> [<params> ...]

Options:
  task: cache
  action: clear


DOC;
    
    /**
     * Tables to truncate
     * @var array Raw DB table sources
     */
    private $_truncates = [
        'audit',
        'audit_detail',
        'category',
        'channel',
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
        'site',
        'site_lang',
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
    ];
    
    /**
     * Deprecated tables
     * @var array Raw DB tables sources to drop
     */
    private $_drops = [
    ];
    
    public $_insert = [
        Role::class => [
            ['index' => 'everyone', 'labelFr' => 'Tous', 'labelEn' => 'Everyone'],
            ['index' => 'guest', 'labelFr' => 'Invité', 'labelEn' => 'Guest'],
            ['index' => 'user', 'labelFr' => 'Utilisateur', 'labelEn' => 'User'],
            ['index' => 'admin', 'labelFr' => 'Administrateur', 'labelEn' => 'Administrator'],
            ['index' => 'dev', 'labelFr' => 'Développeur', 'labelEn' => 'Developer'],
        ],
        User::class => [
            ['username' => 'dev', 'email' => 'dev@zemit.com', 'firstName' => 'Developer', 'lastName' => 'Zemit'],
        ],
        Lang::class => [
            ['label' => 'Francais', 'code' => 'fr'],
            ['label' => 'English', 'code' => 'en'],
            ['label' => 'Spanish', 'code' => 'sp'],
        ],
        Site::class => [
            ['name' => 'Zemit CMS', 'title' => 'Zemit CMS', 'description' => ''],
        ],
        Template::class => [
        ],
        Setting::class => [
        ],
    ];
    
    public function initialize()
    {
        Utils::setUnlimitedRuntime();
        
        // force migration status to the config
        $this->config->app['migration'] = true;
        
        // force permissions to the config
        $permissions = [];
        $permissions[Site::class] = ['*'];
        $permissions[Lang::class] = ['*'];
        $permissions[User::class] = ['*'];
        $permissions[Role::class] = ['*'];
        $permissions[UserRole::class] = ['*'];
        $permissions[Template::class] = ['*'];
        $permissions[Setting::class] = ['*'];
        $this->config->permissions->roles->everyone->models = $permissions;
    }
    
    public function helpAction()
    {
        echo $this->consoleDoc;
    }
    
    /**
     *
     * @return array
     */
    public function mainAction()
    {
        $response = [];
        
        $response ['truncate'] = $this->truncateAction();
        $response ['insert'] = $this->insertAction();
        
        return $response;
    }
    
    /**
     * Truncate tables before inserts
     * @return array
     */
    public function truncateAction()
    {
        $response = [];
        
        /** @var Mysql $db */
        $db = $this->getDi()->getShared('db');
    
        foreach ($this->_truncates as $table) {
            $response [] = $db->execute('TRUNCATE TABLE ' . $db->escapeIdentifier($table));
        }
        
        // double loop for possible fk dependencies
//        foreach ($this->_truncates as $table1) {
//            foreach ($this->_truncates as $table2) {
//                $response [] = $db->execute('TRUNCATE TABLE ' . $db->escapeIdentifier($table1));
//                $response [] = $db->execute('TRUNCATE TABLE ' . $db->escapeIdentifier($table2));
//            }
//        }
//
//        // double loop for possible fk dependencies
//        foreach ($this->_drops as $table1) {
//            foreach ($this->_drops as $table2) {
//                $response [] = $db->execute('DROP TABLE IF EXISTS ' . $db->escapeIdentifier($table1));
//                $response [] = $db->execute('DROP TABLE IF EXISTS ' . $db->escapeIdentifier($table2));
//            }
//        }
        
        return $response;
    }
    
    /**
     * Insert default data
     * @return array[]
     */
    public function insertAction()
    {
        $response = [
            'saved' => [],
            'error' => [],
            'message' => [],
        ];
        
        foreach ($this->_insert as $modelName => $insert) {
            
            foreach ($insert as $row) {
                $entity = new $modelName();
                $entity->assign($row);
                
                if ($modelName === User::class) {
                    if (empty($row['password'])) {
                        $entity->assign(['password' => $row['username'], 'passwordConfirm' => $row['username']]);
                    }
                    $entity->RoleList = [Role::findFirstByIndex($entity->getUsername())];
                }
                
                $saved = $entity->save();
//                $response ['saved'] [] = $saved;
                
                if (!$saved) {
                    $response['error'] [] = $entity->toArray();
                    foreach ($entity->getMessages() as $message) {
                        $response['message'][] = $message;
                    }
                }
            }
        }
        
        return $response;
    }
}
