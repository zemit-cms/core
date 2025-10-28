<?php

use Phalcon\Db\Column;
use Phalcon\Db\Exception;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class RoleRoleMigration_100
 */
class RoleRoleMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     * @throws Exception
     */
    public function morph(): void
    {
        $this->getConnection()->execute('SET FOREIGN_KEY_CHECKS=0;');
        $this->morphTable('role_role', [
            'columns' => [
                new Column(
                    'id',
                    [
                        'type' => Column::TYPE_BIGINTEGER,
                        'unsigned' => true,
                        'notNull' => true,
                        'autoIncrement' => true,
                        'size' => 1,
                        'first' => true
                    ]
                ),
                new Column(
                    'uuid',
                    [
                        'type' => Column::TYPE_CHAR,
                        'notNull' => true,
                        'size' => 36,
                        'after' => 'id'
                    ]
                ),
                new Column(
                    'parent_id',
                    [
                        'type' => Column::TYPE_BIGINTEGER,
                        'unsigned' => true,
                        'notNull' => true,
                        'size' => 1,
                        'after' => 'uuid'
                    ]
                ),
                new Column(
                    'child_id',
                    [
                        'type' => Column::TYPE_BIGINTEGER,
                        'unsigned' => true,
                        'notNull' => true,
                        'size' => 1,
                        'after' => 'parent_id'
                    ]
                ),
                new Column(
                    'position',
                    [
                        'type' => Column::TYPE_INTEGER,
                        'default' => "0",
                        'unsigned' => true,
                        'notNull' => true,
                        'size' => 1,
                        'after' => 'child_id'
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
                        'after' => 'position'
                    ]
                ),
                new Column(
                    'created_at',
                    [
                        'type' => Column::TYPE_DATETIME,
                        'default' => "current_timestamp()",
                        'notNull' => true,
                        'after' => 'deleted'
                    ]
                ),
                new Column(
                    'created_by',
                    [
                        'type' => Column::TYPE_BIGINTEGER,
                        'unsigned' => true,
                        'notNull' => false,
                        'size' => 1,
                        'after' => 'created_at'
                    ]
                ),
            ],
            'indexes' => [
                new Index('PRIMARY', ['id'], 'PRIMARY'),
                new Index('uuid_UNIQUE', ['uuid'], 'UNIQUE'),
                new Index('uq_role_hierarchy', ['parent_id', 'child_id'], 'UNIQUE'),
                new Index('idx_child_id', ['child_id'], ''),
                new Index('fk_role_role_created_by', ['created_by'], ''),
            ],
            'references' => [
                new Reference(
                    'fk_role_role_child_id',
                    [
                        'referencedSchema' => 'zemit_core',
                        'referencedTable' => 'role',
                        'columns' => ['child_id'],
                        'referencedColumns' => ['id'],
                        'onUpdate' => 'CASCADE',
                        'onDelete' => 'CASCADE'
                    ]
                ),
                new Reference(
                    'fk_role_role_created_by',
                    [
                        'referencedSchema' => 'zemit_core',
                        'referencedTable' => 'user',
                        'columns' => ['created_by'],
                        'referencedColumns' => ['id'],
                        'onUpdate' => 'CASCADE',
                        'onDelete' => 'SET NULL'
                    ]
                ),
                new Reference(
                    'fk_role_role_parent_id',
                    [
                        'referencedSchema' => 'zemit_core',
                        'referencedTable' => 'role',
                        'columns' => ['parent_id'],
                        'referencedColumns' => ['id'],
                        'onUpdate' => 'CASCADE',
                        'onDelete' => 'CASCADE'
                    ]
                ),
            ],
            'options' => [
                'TABLE_TYPE' => 'BASE TABLE',
                'AUTO_INCREMENT' => '',
                'ENGINE' => 'InnoDB',
                'TABLE_COLLATION' => 'utf8mb4_general_ci',
            ],
        ]);
    }

    /**
     * Run the migrations
     *
     * @return void
     */
    public function up(): void
    {
    }

    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down(): void
    {
    }
}
