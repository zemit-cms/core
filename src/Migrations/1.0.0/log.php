<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class LogMigration_100
 */
class LogMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('log', [
                'columns' => [
                    new Column(
                        'id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => true,
                            'size' => 1,
                            'first' => true
                        ]
                    ),
                    new Column(
                        'level',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'default' => "0",
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'id'
                        ]
                    ),
                    new Column(
                        'type',
                        [
                            'type' => Column::TYPE_ENUM,
                            'default' => "other",
                            'notNull' => true,
                            'size' => "'critical','alert','error','warning','notice','info','debug','emergency','other'",
                            'after' => 'level'
                        ]
                    ),
                    new Column(
                        'name',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 255,
                            'after' => 'type'
                        ]
                    ),
                    new Column(
                        'message',
                        [
                            'type' => Column::TYPE_TEXT,
                            'notNull' => true,
                            'after' => 'name'
                        ]
                    ),
                    new Column(
                        'context',
                        [
                            'type' => Column::TYPE_TEXT,
                            'notNull' => true,
                            'after' => 'message'
                        ]
                    ),
                    new Column(
                        'date',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'notNull' => true,
                            'after' => 'context'
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
                        'deleted_as',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 1,
                            'after' => 'deleted_at'
                        ]
                    ),
                    new Column(
                        'deleted_by',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 1,
                            'after' => 'deleted_as'
                        ]
                    ),
                    new Column(
                        'restored_at',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'notNull' => false,
                            'after' => 'deleted_by'
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
                    new Index('log_UNIQUE', ['id'], 'UNIQUE'),
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
