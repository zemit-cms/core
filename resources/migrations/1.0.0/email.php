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
                    'template_id',
                    [
                        'type' => Column::TYPE_BIGINTEGER,
                        'unsigned' => true,
                        'notNull' => false,
                        'size' => 1,
                        'after' => 'uuid'
                    ]
                ),
                new Column(
                    'from',
                    [
                        'type' => Column::TYPE_LONGTEXT,
                        'notNull' => true,
                        'after' => 'template_id'
                    ]
                ),
                new Column(
                    'reply_to',
                    [
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => false,
                        'size' => 255,
                        'after' => 'from'
                    ]
                ),
                new Column(
                    'return_path',
                    [
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => false,
                        'size' => 255,
                        'after' => 'reply_to'
                    ]
                ),
                new Column(
                    'read_receipt_to',
                    [
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => false,
                        'size' => 255,
                        'after' => 'return_path'
                    ]
                ),
                new Column(
                    'priority',
                    [
                        'type' => Column::TYPE_TINYINTEGER,
                        'default' => "3",
                        'notNull' => true,
                        'size' => 1,
                        'after' => 'read_receipt_to'
                    ]
                ),
                new Column(
                    'to',
                    [
                        'type' => Column::TYPE_LONGTEXT,
                        'notNull' => true,
                        'after' => 'priority'
                    ]
                ),
                new Column(
                    'cc',
                    [
                        'type' => Column::TYPE_LONGTEXT,
                        'notNull' => false,
                        'after' => 'to'
                    ]
                ),
                new Column(
                    'bcc',
                    [
                        'type' => Column::TYPE_LONGTEXT,
                        'notNull' => false,
                        'after' => 'cc'
                    ]
                ),
                new Column(
                    'subject',
                    [
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => true,
                        'size' => 255,
                        'after' => 'bcc'
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
                        'type' => Column::TYPE_LONGTEXT,
                        'notNull' => false,
                        'after' => 'content'
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
                        'after' => 'meta'
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
                    'deleted',
                    [
                        'type' => Column::TYPE_TINYINTEGER,
                        'default' => "0",
                        'unsigned' => true,
                        'notNull' => true,
                        'size' => 1,
                        'after' => 'sent_at'
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
                new Index('idx_template_id', ['template_id'], ''),
                new Index('fk_email_created_by', ['created_by'], ''),
                new Index('fk_email_updated_by', ['updated_by'], ''),
                new Index('fk_email_deleted_by', ['deleted_by'], ''),
            ],
            'references' => [
                new Reference(
                    'fk_email_created_by',
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
                    'fk_email_deleted_by',
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
                    'fk_email_template_id',
                    [
                        'referencedSchema' => 'zemit_core',
                        'referencedTable' => 'template',
                        'columns' => ['template_id'],
                        'referencedColumns' => ['id'],
                        'onUpdate' => 'CASCADE',
                        'onDelete' => 'SET NULL'
                    ]
                ),
                new Reference(
                    'fk_email_updated_by',
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
