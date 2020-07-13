<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class JobMigration_100
 */
class JobMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('job', [
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
                        'name',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 120,
                            'after' => 'id'
                        ]
                    ),
                    new Column(
                        'slug',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 120,
                            'after' => 'name'
                        ]
                    ),
                    new Column(
                        'type',
                        [
                            'type' => Column::TYPE_CHAR,
                            'notNull' => true,
                            'size' => 20,
                            'after' => 'slug'
                        ]
                    ),
                    new Column(
                        'second',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 2,
                            'after' => 'type'
                        ]
                    ),
                    new Column(
                        'minute',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 2,
                            'after' => 'second'
                        ]
                    ),
                    new Column(
                        'hour',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 2,
                            'after' => 'minute'
                        ]
                    ),
                    new Column(
                        'day',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 2,
                            'after' => 'hour'
                        ]
                    ),
                    new Column(
                        'month',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 2,
                            'after' => 'day'
                        ]
                    ),
                    new Column(
                        'year',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 4,
                            'after' => 'month'
                        ]
                    ),
                    new Column(
                        'javascript',
                        [
                            'type' => Column::TYPE_LONGTEXT,
                            'notNull' => false,
                            'after' => 'year'
                        ]
                    ),
                    new Column(
                        'meta',
                        [
                            'type' => Column::TYPE_LONGTEXT,
                            'notNull' => false,
                            'after' => 'javascript'
                        ]
                    ),
                    new Column(
                        'last_run_result',
                        [
                            'type' => Column::TYPE_LONGTEXT,
                            'notNull' => false,
                            'after' => 'meta'
                        ]
                    ),
                    new Column(
                        'last_run_status',
                        [
                            'type' => Column::TYPE_TINYINTEGER,
                            'default' => "0",
                            'unsigned' => true,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'last_run_result'
                        ]
                    ),
                    new Column(
                        'run_count',
                        [
                            'type' => Column::TYPE_BIGINTEGER,
                            'default' => "0",
                            'unsigned' => true,
                            'notNull' => true,
                            'size' => 20,
                            'after' => 'last_run_status'
                        ]
                    ),
                    new Column(
                        'success_count',
                        [
                            'type' => Column::TYPE_BIGINTEGER,
                            'default' => "0",
                            'unsigned' => true,
                            'notNull' => true,
                            'size' => 20,
                            'after' => 'run_count'
                        ]
                    ),
                    new Column(
                        'error_count',
                        [
                            'type' => Column::TYPE_BIGINTEGER,
                            'default' => "0",
                            'unsigned' => true,
                            'notNull' => true,
                            'size' => 20,
                            'after' => 'success_count'
                        ]
                    ),
                    new Column(
                        'scheduled_at',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'notNull' => false,
                            'after' => 'error_count'
                        ]
                    ),
                    new Column(
                        'ran_at',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'notNull' => false,
                            'after' => 'scheduled_at'
                        ]
                    ),
                    new Column(
                        'created_at',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'default' => "current_timestamp()",
                            'notNull' => true,
                            'after' => 'ran_at'
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
                    new Index('slug_UNIQUE', ['slug'], 'UNIQUE')
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
