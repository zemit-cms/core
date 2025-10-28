<?php

use Phalcon\Db\Column;
use Phalcon\Db\Exception;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class DataMigration_100
 */
class DataMigration_100 extends Migration
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
        $this->morphTable('data', [
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
                    'table_id',
                    [
                        'type' => Column::TYPE_BIGINTEGER,
                        'unsigned' => true,
                        'notNull' => true,
                        'size' => 1,
                        'after' => 'uuid'
                    ]
                ),
                new Column(
                    'record_id',
                    [
                        'type' => Column::TYPE_BIGINTEGER,
                        'unsigned' => true,
                        'notNull' => true,
                        'size' => 1,
                        'after' => 'table_id'
                    ]
                ),
                new Column(
                    'column_id',
                    [
                        'type' => Column::TYPE_BIGINTEGER,
                        'unsigned' => true,
                        'notNull' => true,
                        'size' => 1,
                        'after' => 'record_id'
                    ]
                ),
                new Column(
                    'value',
                    [
                        'type' => Column::TYPE_MEDIUMTEXT,
                        'notNull' => false,
                        'after' => 'column_id'
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
                        'after' => 'value'
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
                new Column(
                    'updated_at',
                    [
                        'type' => Column::TYPE_DATETIME,
                        'notNull' => false,
                        'after' => 'created_by'
                    ]
                ),
                new Column(
                    'updated_by',
                    [
                        'type' => Column::TYPE_BIGINTEGER,
                        'unsigned' => true,
                        'notNull' => false,
                        'size' => 1,
                        'after' => 'updated_at'
                    ]
                ),
                new Column(
                    'deleted_at',
                    [
                        'type' => Column::TYPE_DATETIME,
                        'notNull' => false,
                        'after' => 'updated_by'
                    ]
                ),
                new Column(
                    'deleted_by',
                    [
                        'type' => Column::TYPE_BIGINTEGER,
                        'unsigned' => true,
                        'notNull' => false,
                        'size' => 1,
                        'after' => 'deleted_at'
                    ]
                ),
            ],
            'indexes' => [
                new Index('PRIMARY', ['id'], 'PRIMARY'),
                new Index('uuid_UNIQUE', ['uuid'], 'UNIQUE'),
                new Index('uq_cell', ['record_id', 'column_id'], 'UNIQUE'),
                new Index('idx_column_id', ['column_id'], ''),
                new Index('fk_data_created_by', ['created_by'], ''),
                new Index('fk_data_updated_by', ['updated_by'], ''),
                new Index('fk_data_deleted_by', ['deleted_by'], ''),
                new Index('fk_data_table_id', ['table_id'], ''),
                new Index('value_fulltext', ['value'], 'FULLTEXT'),
            ],
            'references' => [
                new Reference(
                    'fk_data_column_id',
                    [
                        'referencedSchema' => 'zemit_core',
                        'referencedTable' => 'column',
                        'columns' => ['column_id'],
                        'referencedColumns' => ['id'],
                        'onUpdate' => 'CASCADE',
                        'onDelete' => 'CASCADE'
                    ]
                ),
                new Reference(
                    'fk_data_created_by',
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
                    'fk_data_deleted_by',
                    [
                        'referencedSchema' => 'zemit_core',
                        'referencedTable' => 'user',
                        'columns' => ['deleted_by'],
                        'referencedColumns' => ['id'],
                        'onUpdate' => 'CASCADE',
                        'onDelete' => 'SET NULL'
                    ]
                ),
                new Reference(
                    'fk_data_record_id',
                    [
                        'referencedSchema' => 'zemit_core',
                        'referencedTable' => 'record',
                        'columns' => ['record_id'],
                        'referencedColumns' => ['id'],
                        'onUpdate' => 'CASCADE',
                        'onDelete' => 'CASCADE'
                    ]
                ),
                new Reference(
                    'fk_data_table_id',
                    [
                        'referencedSchema' => 'zemit_core',
                        'referencedTable' => 'table',
                        'columns' => ['table_id'],
                        'referencedColumns' => ['id'],
                        'onUpdate' => 'CASCADE',
                        'onDelete' => 'CASCADE'
                    ]
                ),
                new Reference(
                    'fk_data_updated_by',
                    [
                        'referencedSchema' => 'zemit_core',
                        'referencedTable' => 'user',
                        'columns' => ['updated_by'],
                        'referencedColumns' => ['id'],
                        'onUpdate' => 'CASCADE',
                        'onDelete' => 'SET NULL'
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
