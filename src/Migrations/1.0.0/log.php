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
                            'autoIncrement' => true,
                            'size' => 10,
                            'first' => true
                        ]
                    ),
                    new Column(
                        'log_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 10,
                            'after' => 'id'
                        ]
                    ),
                    new Column(
                        'table',
                        [
                            'type' => Column::TYPE_CHAR,
                            'notNull' => true,
                            'size' => 60,
                            'after' => 'log_id'
                        ]
                    ),
                    new Column(
                        'table_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 10,
                            'after' => 'table'
                        ]
                    ),
                    new Column(
                        'user_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 10,
                            'after' => 'table_id'
                        ]
                    ),
                    new Column(
                        'client_ip',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => false,
                            'size' => 16,
                            'after' => 'user_id'
                        ]
                    ),
                    new Column(
                        'server_ip',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => false,
                            'size' => 16,
                            'after' => 'client_ip'
                        ]
                    ),
                    new Column(
                        'before',
                        [
                            'type' => Column::TYPE_TEXT,
                            'notNull' => false,
                            'after' => 'server_ip'
                        ]
                    ),
                    new Column(
                        'after',
                        [
                            'type' => Column::TYPE_TEXT,
                            'notNull' => false,
                            'after' => 'before'
                        ]
                    ),
                    new Column(
                        'meta',
                        [
                            'type' => Column::TYPE_TEXT,
                            'notNull' => false,
                            'after' => 'after'
                        ]
                    ),
                    new Column(
                        'created_date',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'notNull' => false,
                            'after' => 'meta'
                        ]
                    ),
                    new Column(
                        'updated_date',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'notNull' => false,
                            'after' => 'created_date'
                        ]
                    ),
                    new Column(
                        'deleted',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'default' => "0",
                            'unsigned' => true,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'updated_date'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id'], 'PRIMARY'),
                    new Index('id_UNIQUE', ['id'], 'UNIQUE'),
                    new Index('id_index', ['id'], ''),
                    new Index('table_index', ['table'], ''),
                    new Index('table_id_index', ['table_id'], ''),
                    new Index('table_table_id_index', ['table', 'table_id'], ''),
                    new Index('deleted_index', ['deleted'], ''),
                    new Index('user_id_index', ['user_id'], ''),
                    new Index('client_ip_index', ['client_ip'], ''),
                    new Index('server_ip_index', ['server_ip'], '')
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
