<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class FlagMigration_100
 */
class FlagMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('flag', [
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
                        'site_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'id'
                        ]
                    ),
                    new Column(
                        'page_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 1,
                            'after' => 'site_id'
                        ]
                    ),
                    new Column(
                        'lang_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 1,
                            'after' => 'page_id'
                        ]
                    ),
                    new Column(
                        'label',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 255,
                            'after' => 'lang_id'
                        ]
                    ),
                    new Column(
                        'index',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 255,
                            'after' => 'label'
                        ]
                    ),
                    new Column(
                        'value',
                        [
                            'type' => Column::TYPE_TINYINTEGER,
                            'default' => "1",
                            'unsigned' => true,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'index'
                        ]
                    ),
                    new Column(
                        'meta',
                        [
                            'type' => Column::TYPE_JSON,
                            'notNull' => false,
                            'size' => 1,
                            'after' => 'value'
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
                            'after' => 'meta'
                        ]
                    ),
                    new Column(
                        'created_at',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'notNull' => false,
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
                    new Index('id_UNIQUE', ['id'], 'UNIQUE')
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
