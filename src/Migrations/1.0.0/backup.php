<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class BackupMigration_100
 */
class BackupMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('backup', [
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
                        'name',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 255,
                            'after' => 'user_id'
                        ]
                    ),
                    new Column(
                        'path',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => false,
                            'size' => 255,
                            'after' => 'name'
                        ]
                    ),
                    new Column(
                        'mimetype',
                        [
                            'type' => Column::TYPE_CHAR,
                            'notNull' => false,
                            'size' => 60,
                            'after' => 'path'
                        ]
                    ),
                    new Column(
                        'type',
                        [
                            'type' => Column::TYPE_CHAR,
                            'notNull' => true,
                            'size' => 60,
                            'after' => 'mimetype'
                        ]
                    ),
                    new Column(
                        'completed',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'default' => "0",
                            'unsigned' => true,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'type'
                        ]
                    ),
                    new Column(
                        'downloaded',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 2,
                            'after' => 'completed'
                        ]
                    ),
                    new Column(
                        'uploaded',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'default' => "0",
                            'unsigned' => true,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'downloaded'
                        ]
                    ),
                    new Column(
                        'external',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'default' => "0",
                            'unsigned' => true,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'uploaded'
                        ]
                    ),
                    new Column(
                        'status',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 2,
                            'after' => 'external'
                        ]
                    ),
                    new Column(
                        'created_date',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'notNull' => false,
                            'after' => 'status'
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
                    new Index('user_id_index', ['user_id'], ''),
                    new Index('mimetype_index', ['mimetype'], ''),
                    new Index('type_index', ['type'], ''),
                    new Index('completed_index', ['completed'], ''),
                    new Index('downloaded_index', ['downloaded'], ''),
                    new Index('uploaded_index', ['uploaded'], ''),
                    new Index('external_index', ['external'], ''),
                    new Index('status_index', ['status'], ''),
                    new Index('deleted_index', ['deleted'], '')
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
