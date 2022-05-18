<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class PermissionMigration_100
 */
class PermissionMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('permission', [
                'columns' => [
                    new Column(
                        'id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => true,
                            'autoIncrement' => true,
                            'size' => 10,
                            'first' => true
                        ]
                    ),
                    new Column(
                        'deny',
                        [
                            'type' => Column::TYPE_TINYINTEGER,
                            'default' => "0",
                            'unsigned' => true,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'id'
                        ]
                    ),
                    new Column(
                        'workspace_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 10,
                            'after' => 'deny'
                        ]
                    ),
                    new Column(
                        'project_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 10,
                            'after' => 'workspace_id'
                        ]
                    ),
                    new Column(
                        'user_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 10,
                            'after' => 'project_id'
                        ]
                    ),
                    new Column(
                        'role_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 10,
                            'after' => 'user_id'
                        ]
                    ),
                    new Column(
                        'file_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 10,
                            'after' => 'role_id'
                        ]
                    ),
                    new Column(
                        'locale_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 10,
                            'after' => 'file_id'
                        ]
                    ),
                    new Column(
                        'template_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 10,
                            'after' => 'locale_id'
                        ]
                    ),
                    new Column(
                        'channel_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 10,
                            'after' => 'template_id'
                        ]
                    ),
                    new Column(
                        'channel_field_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 10,
                            'after' => 'channel_id'
                        ]
                    ),
                    new Column(
                        'endpoint_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 10,
                            'after' => 'channel_field_id'
                        ]
                    ),
                    new Column(
                        'endpoint_field_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 10,
                            'after' => 'endpoint_id'
                        ]
                    ),
                    new Column(
                        'endpoint_version_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 10,
                            'after' => 'endpoint_field_id'
                        ]
                    ),
                    new Column(
                        'field_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 10,
                            'after' => 'endpoint_version_id'
                        ]
                    ),
                    new Column(
                        'version_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 10,
                            'after' => 'field_id'
                        ]
                    ),
                    new Column(
                        'meta',
                        [
                            'type' => Column::TYPE_LONGTEXT,
                            'notNull' => false,
                            'after' => 'version_id'
                        ]
                    ),
                    new Column(
                        'created_at',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'default' => "current_timestamp()",
                            'notNull' => true,
                            'after' => 'meta'
                        ]
                    ),
                    new Column(
                        'updated_at',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'notNull' => false,
                            'after' => 'created_at'
                        ]
                    ),
                    new Column(
                        'deleted_at',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'notNull' => false,
                            'after' => 'updated_at'
                        ]
                    ),
                    new Column(
                        'deprecated_at',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'notNull' => false,
                            'after' => 'deleted_at'
                        ]
                    ),
                    new Column(
                        'deleted',
                        [
                            'type' => Column::TYPE_TINYINTEGER,
                            'default' => "0",
                            'unsigned' => true,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'deprecated_at'
                        ]
                    ),
                    new Column(
                        'deprecated',
                        [
                            'type' => Column::TYPE_TINYINTEGER,
                            'default' => "0",
                            'unsigned' => true,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'deleted'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id'], 'PRIMARY'),
                    new Index('id_UNIQUE', ['id'], 'UNIQUE'),
                    new Index('permission_channel_id_fk_idx', ['channel_id'], ''),
                    new Index('permission_workspace_id_fk_idx', ['workspace_id'], ''),
                    new Index('permission_project_id_fk_idx', ['project_id'], ''),
                    new Index('permission_user_id_fk_idx', ['user_id'], ''),
                    new Index('permission_role_id_fk_idx', ['role_id'], ''),
                    new Index('permission_file_id_fk_idx', ['file_id'], ''),
                    new Index('permission_locale_id_fk_idx', ['locale_id'], ''),
                    new Index('permission_template_id_fk_idx', ['template_id'], ''),
                    new Index('permission_channel_field_id_fk_idx', ['channel_field_id'], ''),
                    new Index('permission_endpoint_id_fk_idx', ['endpoint_id'], ''),
                    new Index('permission_endpoint_version_id_fk_idx', ['endpoint_version_id'], ''),
                    new Index('permission_endpoint_field_id_fk_idx', ['endpoint_field_id'], ''),
                    new Index('permission_field_id_fk_idx', ['field_id'], ''),
                    new Index('permission_version_id_fk_idx', ['version_id'], '')
                ],
                'references' => [
                    new Reference(
                        'permission_channel_field_id_fk',
                        [
                            'referencedTable' => 'channel_field',
                            'referencedSchema' => 'zemit',
                            'columns' => ['channel_field_id'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'CASCADE',
                            'onDelete' => 'CASCADE'
                        ]
                    ),
                    new Reference(
                        'permission_channel_id_fk',
                        [
                            'referencedTable' => 'channel',
                            'referencedSchema' => 'zemit',
                            'columns' => ['channel_id'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'CASCADE',
                            'onDelete' => 'CASCADE'
                        ]
                    ),
                    new Reference(
                        'permission_endpoint_field_id_fk',
                        [
                            'referencedTable' => 'endpoint_field',
                            'referencedSchema' => 'zemit',
                            'columns' => ['endpoint_field_id'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'CASCADE',
                            'onDelete' => 'CASCADE'
                        ]
                    ),
                    new Reference(
                        'permission_endpoint_id_fk',
                        [
                            'referencedTable' => 'endpoint',
                            'referencedSchema' => 'zemit',
                            'columns' => ['endpoint_id'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'CASCADE',
                            'onDelete' => 'CASCADE'
                        ]
                    ),
                    new Reference(
                        'permission_endpoint_version_id_fk',
                        [
                            'referencedTable' => 'endpoint_version',
                            'referencedSchema' => 'zemit',
                            'columns' => ['endpoint_version_id'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'CASCADE',
                            'onDelete' => 'CASCADE'
                        ]
                    ),
                    new Reference(
                        'permission_field_id_fk',
                        [
                            'referencedTable' => 'field',
                            'referencedSchema' => 'zemit',
                            'columns' => ['field_id'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'CASCADE',
                            'onDelete' => 'CASCADE'
                        ]
                    ),
                    new Reference(
                        'permission_file_id_fk',
                        [
                            'referencedTable' => 'file',
                            'referencedSchema' => 'zemit',
                            'columns' => ['file_id'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'CASCADE',
                            'onDelete' => 'CASCADE'
                        ]
                    ),
                    new Reference(
                        'permission_locale_id_fk',
                        [
                            'referencedTable' => 'locale',
                            'referencedSchema' => 'zemit',
                            'columns' => ['locale_id'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'CASCADE',
                            'onDelete' => 'CASCADE'
                        ]
                    ),
                    new Reference(
                        'permission_project_id_fk',
                        [
                            'referencedTable' => 'project',
                            'referencedSchema' => 'zemit',
                            'columns' => ['project_id'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'CASCADE',
                            'onDelete' => 'CASCADE'
                        ]
                    ),
                    new Reference(
                        'permission_role_id_fk',
                        [
                            'referencedTable' => 'role',
                            'referencedSchema' => 'zemit',
                            'columns' => ['role_id'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'CASCADE',
                            'onDelete' => 'CASCADE'
                        ]
                    ),
                    new Reference(
                        'permission_template_id_fk',
                        [
                            'referencedTable' => 'template',
                            'referencedSchema' => 'zemit',
                            'columns' => ['template_id'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'CASCADE',
                            'onDelete' => 'CASCADE'
                        ]
                    ),
                    new Reference(
                        'permission_user_id_fk',
                        [
                            'referencedTable' => 'user',
                            'referencedSchema' => 'zemit',
                            'columns' => ['user_id'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'CASCADE',
                            'onDelete' => 'CASCADE'
                        ]
                    ),
                    new Reference(
                        'permission_version_id_fk',
                        [
                            'referencedTable' => 'version',
                            'referencedSchema' => 'zemit',
                            'columns' => ['version_id'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'CASCADE',
                            'onDelete' => 'CASCADE'
                        ]
                    ),
                    new Reference(
                        'permission_workspace_id_fk',
                        [
                            'referencedTable' => 'workspace',
                            'referencedSchema' => 'zemit',
                            'columns' => ['workspace_id'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'CASCADE',
                            'onDelete' => 'CASCADE'
                        ]
                    )
                ],
                'options' => [
                    'table_type' => 'BASE TABLE',
                    'auto_increment' => '',
                    'engine' => 'InnoDB',
                    'table_collation' => 'utf8mb4_general_ci'
                ],
            ]
        );
    }

    /**
     * Run the migrations
     *
     * @return void
     */
    public function up()
    {

    }

    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down()
    {

    }

}
