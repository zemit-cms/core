<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class ValueMigration_100
 */
class ValueMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('value', [
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
                        'workspace_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => true,
                            'size' => 10,
                            'after' => 'id'
                        ]
                    ),
                    new Column(
                        'project_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => true,
                            'size' => 10,
                            'after' => 'workspace_id'
                        ]
                    ),
                    new Column(
                        'locale_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 10,
                            'after' => 'project_id'
                        ]
                    ),
                    new Column(
                        'channel_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => true,
                            'size' => 10,
                            'after' => 'locale_id'
                        ]
                    ),
                    new Column(
                        'field_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => true,
                            'size' => 10,
                            'after' => 'channel_id'
                        ]
                    ),
                    new Column(
                        'value_int',
                        [
                            'type' => Column::TYPE_BIGINTEGER,
                            'notNull' => false,
                            'size' => 20,
                            'after' => 'field_id'
                        ]
                    ),
                    new Column(
                        'value_string',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => false,
                            'size' => 191,
                            'after' => 'value_int'
                        ]
                    ),
                    new Column(
                        'value_text',
                        [
                            'type' => Column::TYPE_TEXT,
                            'notNull' => false,
                            'after' => 'value_string'
                        ]
                    ),
                    new Column(
                        'value_json',
                        [
                            'type' => Column::TYPE_TEXT,
                            'notNull' => false,
                            'after' => 'value_text'
                        ]
                    ),
                    new Column(
                        'value_date',
                        [
                            'type' => Column::TYPE_DATE,
                            'notNull' => false,
                            'after' => 'value_json'
                        ]
                    ),
                    new Column(
                        'value_datetime',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'notNull' => false,
                            'after' => 'value_date'
                        ]
                    ),
                    new Column(
                        'value_datetime_end',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'notNull' => false,
                            'after' => 'value_datetime'
                        ]
                    ),
                    new Column(
                        'value_timestamp',
                        [
                            'type' => Column::TYPE_TIMESTAMP,
                            'notNull' => false,
                            'after' => 'value_datetime_end'
                        ]
                    ),
                    new Column(
                        'value_binary',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => false,
                            'size' => 1,
                            'after' => 'value_timestamp'
                        ]
                    ),
                    new Column(
                        'value_blob',
                        [
                            'type' => Column::TYPE_BLOB,
                            'notNull' => false,
                            'size' => 1,
                            'after' => 'value_binary'
                        ]
                    ),
                    new Column(
                        'meta',
                        [
                            'type' => Column::TYPE_TEXT,
                            'notNull' => false,
                            'after' => 'value_blob'
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
                        'generic',
                        [
                            'type' => Column::TYPE_TINYINTEGER,
                            'notNull' => false,
                            'size' => 1,
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
                            'after' => 'generic'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id'], 'PRIMARY'),
                    new Index('id_UNIQUE', ['id'], 'UNIQUE'),
                    new Index('value_workspace_id_fk_idx', ['workspace_id'], ''),
                    new Index('value_project_id_fk_idx', ['project_id'], ''),
                    new Index('value_channel_id_fk_idx', ['channel_id'], ''),
                    new Index('value_field_id_fk_idx', ['field_id'], ''),
                    new Index('value_locale_id_fk_idx', ['locale_id'], '')
                ],
                'references' => [
                    new Reference(
                        'value_channel_id_fk',
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
                        'value_field_id_fk',
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
                        'value_locale_id_fk',
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
                        'value_project_id_fk',
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
                        'value_workspace_id_fk',
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
