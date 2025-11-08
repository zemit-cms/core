<?php

use Phalcon\Db\Column;
use Phalcon\Db\Exception;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class EmailFileMigration_100
 */
class EmailFileMigration_100 extends Migration
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
        $this->morphTable('email_file', [
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
                    'email_id',
                    [
                        'type' => Column::TYPE_BIGINTEGER,
                        'unsigned' => true,
                        'notNull' => true,
                        'size' => 1,
                        'after' => 'uuid'
                    ]
                ),
                new Column(
                    'file_id',
                    [
                        'type' => Column::TYPE_BIGINTEGER,
                        'unsigned' => true,
                        'notNull' => true,
                        'size' => 1,
                        'after' => 'email_id'
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
                        'after' => 'file_id'
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
            ],
            'indexes' => [
                new Index('PRIMARY', ['id'], 'PRIMARY'),
                new Index('uuid_UNIQUE', ['uuid'], 'UNIQUE'),
                new Index('uq_email_file', ['email_id', 'file_id'], 'UNIQUE'),
                new Index('idx_file_id', ['file_id'], ''),
                new Index('fk_email_file_created_by', ['created_by'], ''),
            ],
            'references' => [
                new Reference(
                    'fk_email_file_created_by',
                    [
                        'referencedSchema' => 'phalcon_kit',
                        'referencedTable' => 'user',
                        'columns' => ['created_by'],
                        'referencedColumns' => ['id'],
                        'onUpdate' => 'CASCADE',
                        'onDelete' => 'SET NULL'
                    ]
                ),
                new Reference(
                    'fk_email_file_email_id',
                    [
                        'referencedSchema' => 'phalcon_kit',
                        'referencedTable' => 'email',
                        'columns' => ['email_id'],
                        'referencedColumns' => ['id'],
                        'onUpdate' => 'CASCADE',
                        'onDelete' => 'CASCADE'
                    ]
                ),
                new Reference(
                    'fk_email_file_file_id',
                    [
                        'referencedSchema' => 'phalcon_kit',
                        'referencedTable' => 'file',
                        'columns' => ['file_id'],
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
