<?php 

use Phalcon\Db\Column;
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
     */
    public function morph()
    {
        $this->morphTable('session', [
                'columns' => [
                    new Column(
                        'id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => true,
                            'autoIncrement' => true,
                            'size' => 1,
                            'first' => true
                        ]
                    ),
                    new Column(
                        'user_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 1,
                            'after' => 'id'
                        ]
                    ),
                    new Column(
                        'as_user_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 1,
                            'after' => 'user_id'
                        ]
                    ),
                    new Column(
                        'key',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 60,
                            'after' => 'as_user_id'
                        ]
                    ),
                    new Column(
                        'token',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 128,
                            'after' => 'key'
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
                            'type' => Column::TYPE_TEXT,
                            'notNull' => false,
                            'after' => 'jwt'
                        ]
                    ),
                    new Column(
                        'date',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'notNull' => true,
                            'after' => 'meta'
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
                            'after' => 'date'
                        ]
                    ),
                    new Column(
                        'created_at',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'default' => "CURRENT_TIMESTAMP",
                            'notNull' => true,
                            'after' => 'deleted'
                        ]
                    ),
                    new Column(
                        'created_by',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 1,
                            'after' => 'created_at'
                        ]
                    ),
                    new Column(
                        'created_as',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 1,
                            'after' => 'created_by'
                        ]
                    ),
                    new Column(
                        'updated_at',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'notNull' => false,
                            'after' => 'created_as'
                        ]
                    ),
                    new Column(
                        'updated_by',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 1,
                            'after' => 'updated_at'
                        ]
                    ),
                    new Column(
                        'updated_as',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 1,
                            'after' => 'updated_by'
                        ]
                    ),
                    new Column(
                        'deleted_at',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'notNull' => false,
                            'after' => 'updated_as'
                        ]
                    ),
                    new Column(
                        'deleted_by',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 1,
                            'after' => 'deleted_at'
                        ]
                    ),
                    new Column(
                        'deleted_as',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 1,
                            'after' => 'deleted_by'
                        ]
                    ),
                    new Column(
                        'restored_at',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'notNull' => false,
                            'after' => 'deleted_as'
                        ]
                    ),
                    new Column(
                        'restored_by',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 1,
                            'after' => 'restored_at'
                        ]
                    ),
                    new Column(
                        'restored_as',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 1,
                            'after' => 'restored_by'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id'], 'PRIMARY'),
                    new Index('id_UNIQUE', ['id'], 'UNIQUE'),
                    new Index('user_id', ['user_id'], ''),
                    new Index('as_user_id', ['as_user_id'], ''),
                    new Index('key', ['key'], ''),
                    new Index('token', ['token'], ''),
                    new Index('created_by', ['created_by'], ''),
                    new Index('created_as', ['created_as'], ''),
                    new Index('updated_by', ['updated_by'], ''),
                    new Index('updated_as', ['updated_as'], ''),
                    new Index('deleted_by', ['deleted_by'], ''),
                    new Index('deleted_as', ['deleted_as'], ''),
                    new Index('restored_by', ['restored_by'], ''),
                    new Index('restored_as', ['restored_as'], '')
                ],
                'options' => [
                    'table_type' => 'BASE TABLE',
                    'auto_increment' => '',
                    'engine' => 'InnoDB',
                    'table_collation' => 'utf8_general_ci'
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
