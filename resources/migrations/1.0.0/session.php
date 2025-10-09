<?php

use Phalcon\Db\Column;
use Phalcon\Db\Exception;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class SessionMigration_100
 */
class SessionMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     * @throws Exception
     */
    public function morph(): void
    {
        $this->morphTable('session', [
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
                    'user_id',
                    [
                        'type' => Column::TYPE_BIGINTEGER,
                        'unsigned' => true,
                        'notNull' => false,
                        'size' => 1,
                        'after' => 'uuid'
                    ]
                ),
                new Column(
                    'as_user_id',
                    [
                        'type' => Column::TYPE_BIGINTEGER,
                        'unsigned' => true,
                        'notNull' => false,
                        'size' => 1,
                        'after' => 'user_id'
                    ]
                ),
                new Column(
                    'token',
                    [
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => true,
                        'size' => 128,
                        'after' => 'as_user_id'
                    ]
                ),
                new Column(
                    'jwt',
                    [
                        'type' => Column::TYPE_TEXT,
                        'notNull' => false,
                        'after' => 'token'
                    ]
                ),
                new Column(
                    'meta',
                    [
                        'type' => Column::TYPE_LONGTEXT,
                        'notNull' => false,
                        'after' => 'jwt'
                    ]
                ),
                new Column(
                    'expires_at',
                    [
                        'type' => Column::TYPE_DATETIME,
                        'notNull' => true,
                        'after' => 'meta'
                    ]
                ),
                new Column(
                    'created_at',
                    [
                        'type' => Column::TYPE_DATETIME,
                        'default' => "current_timestamp()",
                        'notNull' => true,
                        'after' => 'expires_at'
                    ]
                ),
            ],
            'indexes' => [
                new Index('PRIMARY', ['id'], 'PRIMARY'),
                new Index('uuid_UNIQUE', ['uuid'], 'UNIQUE'),
                new Index('token_UNIQUE', ['token'], 'UNIQUE'),
                new Index('idx_user_id', ['user_id'], ''),
                new Index('idx_expires_at', ['expires_at'], ''),
                new Index('fk_session_as_user_id', ['as_user_id'], ''),
            ],
            'references' => [
                new Reference(
                    'fk_session_as_user_id',
                    [
                        'referencedSchema' => 'zemit_core',
                        'referencedTable' => 'user',
                        'columns' => ['as_user_id'],
                        'referencedColumns' => ['id'],
                        'onUpdate' => 'CASCADE',
                        'onDelete' => 'CASCADE'
                    ]
                ),
                new Reference(
                    'fk_session_user_id',
                    [
                        'referencedSchema' => 'zemit_core',
                        'referencedTable' => 'user',
                        'columns' => ['user_id'],
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
