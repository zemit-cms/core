<?php

use Phalcon\Db\Column;
use Phalcon\Db\Exception;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class EmailMigration_100
 */
class EmailMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     * @throws Exception
     */
    public function morph(): void
    {
        $this->morphTable('email', [
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
                    'template_id',
                    [
                        'type' => Column::TYPE_INTEGER,
                        'unsigned' => true,
                        'notNull' => true,
                        'size' => 1,
                        'after' => 'id'
                    ]
                ),
                new Column(
                    'uuid',
                    [
                        'type' => Column::TYPE_CHAR,
                        'notNull' => true,
                        'size' => 36,
                        'after' => 'template_id'
                    ]
                ),
                new Column(
                    'from',
                    [
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => true,
                        'size' => 500,
                        'after' => 'uuid'
                    ]
                ),
                new Column(
                    'to',
                    [
                        'type' => Column::TYPE_TEXT,
                        'notNull' => true,
                        'after' => 'from'
                    ]
                ),
                new Column(
                    'cc',
                    [
                        'type' => Column::TYPE_TEXT,
                        'notNull' => false,
                        'after' => 'to'
                    ]
                ),
                new Column(
                    'bcc',
                    [
                        'type' => Column::TYPE_TEXT,
                        'notNull' => false,
                        'after' => 'cc'
                    ]
                ),
                new Column(
                    'read_receipt_to',
                    [
                        'type' => Column::TYPE_TEXT,
                        'notNull' => false,
                        'after' => 'bcc'
                    ]
                ),
                new Column(
                    'subject',
                    [
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => true,
                        'size' => 255,
                        'after' => 'read_receipt_to'
                    ]
                ),
                new Column(
                    'content',
                    [
                        'type' => Column::TYPE_MEDIUMTEXT,
                        'notNull' => true,
                        'after' => 'subject'
                    ]
                ),
                new Column(
                    'meta',
                    [
                        'type' => Column::TYPE_MEDIUMTEXT,
                        'notNull' => false,
                        'after' => 'content'
                    ]
                ),
                new Column(
                    'view_path',
                    [
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => false,
                        'size' => 255,
                        'after' => 'meta'
                    ]
                ),
                new Column(
                    'sent',
                    [
                        'type' => Column::TYPE_TINYINTEGER,
                        'default' => "0",
                        'unsigned' => true,
                        'notNull' => true,
                        'size' => 1,
                        'after' => 'view_path'
                    ]
                ),
                new Column(
                    'sent_at',
                    [
                        'type' => Column::TYPE_DATETIME,
                        'notNull' => false,
                        'after' => 'sent'
                    ]
                ),
                new Column(
                    'sent_by',
                    [
                        'type' => Column::TYPE_INTEGER,
                        'unsigned' => true,
                        'notNull' => false,
                        'size' => 1,
                        'after' => 'sent_at'
                    ]
                ),
                new Column(
                    'sent_as',
                    [
                        'type' => Column::TYPE_INTEGER,
                        'unsigned' => true,
                        'notNull' => false,
                        'size' => 1,
                        'after' => 'sent_by'
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
                        'after' => 'sent_as'
                    ]
                ),
                new Column(
                    'created_at',
                    [
                        'type' => Column::TYPE_DATETIME,
                        'default' => "NOW()",
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
                ),
            ],
            'indexes' => [
                new Index('PRIMARY', ['id'], 'PRIMARY'),
                new Index('id_UNIQUE', ['id'], 'UNIQUE'),
                new Index('uuid_UNIQUE', ['uuid'], 'UNIQUE'),
                new Index('template_id', ['template_id'], ''),
                new Index('uuid', ['uuid'], ''),
                new Index('created_by', ['created_by'], ''),
                new Index('created_as', ['created_as'], ''),
                new Index('updated_by', ['updated_by'], ''),
                new Index('updated_as', ['updated_as'], ''),
                new Index('deleted_by', ['deleted_by'], ''),
                new Index('deleted_as', ['deleted_as'], ''),
                new Index('restored_by', ['restored_by'], ''),
                new Index('restored_as', ['restored_as'], ''),
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
