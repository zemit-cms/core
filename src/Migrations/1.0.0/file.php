<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class FileMigration_100
 */
class FileMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('file', [
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
                        'user_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 10,
                            'after' => 'id'
                        ]
                    ),
                    new Column(
                        'key',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => false,
                            'size' => 191,
                            'after' => 'user_id'
                        ]
                    ),
                    new Column(
                        'path',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => false,
                            'size' => 191,
                            'after' => 'key'
                        ]
                    ),
                    new Column(
                        'type',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => false,
                            'size' => 191,
                            'after' => 'path'
                        ]
                    ),
                    new Column(
                        'type_real',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => false,
                            'size' => 120,
                            'after' => 'type'
                        ]
                    ),
                    new Column(
                        'extension',
                        [
                            'type' => Column::TYPE_CHAR,
                            'notNull' => false,
                            'size' => 6,
                            'after' => 'type_real'
                        ]
                    ),
                    new Column(
                        'name',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => false,
                            'size' => 191,
                            'after' => 'extension'
                        ]
                    ),
                    new Column(
                        'name_temp',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => false,
                            'size' => 191,
                            'after' => 'name'
                        ]
                    ),
                    new Column(
                        'size',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => false,
                            'size' => 45,
                            'after' => 'name_temp'
                        ]
                    ),
                    new Column(
                        'error',
                        [
                            'type' => Column::TYPE_TEXT,
                            'notNull' => false,
                            'after' => 'size'
                        ]
                    ),
                    new Column(
                        'created_date',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'notNull' => false,
                            'after' => 'error'
                        ]
                    ),
                    new Column(
                        'deleted',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'created_date'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id'], 'PRIMARY'),
                    new Index('id_UNIQUE', ['id'], 'UNIQUE'),
                    new Index('deleted_index', ['deleted'], ''),
                    new Index('id_index', ['id'], ''),
                    new Index('user_id_index', ['user_id'], '')
                ],
                'references' => [
                    new Reference(
                        'file_user_id_fk',
                        [
                            'referencedTable' => 'user',
                            'referencedSchema' => 'zemit',
                            'columns' => ['user_id'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'CASCADE',
                            'onDelete' => 'SET NULL'
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
