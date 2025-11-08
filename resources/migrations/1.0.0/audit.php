<?php


use Phalcon\Db\Column;
use Phalcon\Db\Exception;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class AuditMigration_100
 */
class AuditMigration_100 extends Migration
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
        $this->morphTable('audit', [
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
                    'parent_id',
                    [
                        'type' => Column::TYPE_BIGINTEGER,
                        'unsigned' => true,
                        'notNull' => false,
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
                        'after' => 'parent_id'
                    ]
                ),
                new Column(
                    'model',
                    [
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => true,
                        'size' => 255,
                        'comment' => "The class name of the model being changed",
                        'after' => 'uuid'
                    ]
                ),
                new Column(
                    'table',
                    [
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => true,
                        'size' => 60,
                        'comment' => "The database table name",
                        'after' => 'model'
                    ]
                ),
                new Column(
                    'primary',
                    [
                        'type' => Column::TYPE_BIGINTEGER,
                        'unsigned' => true,
                        'notNull' => true,
                        'size' => 1,
                        'comment' => "The primary key of the record being changed",
                        'after' => 'table'
                    ]
                ),
                new Column(
                    'event',
                    [
                        'type' => Column::TYPE_ENUM,
                        'default' => "other",
                        'notNull' => true,
                        'size' => "'create','update','delete','restore','other'",
                        'after' => 'primary'
                    ]
                ),
                new Column(
                    'before',
                    [
                        'type' => Column::TYPE_LONGTEXT,
                        'notNull' => false,
                        'comment' => "JSON snapshot of data before the change",
                        'after' => 'event'
                    ]
                ),
                new Column(
                    'after',
                    [
                        'type' => Column::TYPE_LONGTEXT,
                        'notNull' => false,
                        'comment' => "JSON snapshot of data after the change",
                        'after' => 'before'
                    ]
                ),
                new Column(
                    'created_at',
                    [
                        'type' => Column::TYPE_DATETIME,
                        'default' => "current_timestamp()",
                        'notNull' => true,
                        'after' => 'after'
                    ]
                ),
                new Column(
                    'created_by',
                    [
                        'type' => Column::TYPE_BIGINTEGER,
                        'unsigned' => true,
                        'notNull' => false,
                        'size' => 1,
                        'comment' => "The user who performed the action",
                        'after' => 'created_at'
                    ]
                ),
                new Column(
                    'created_as',
                    [
                        'type' => Column::TYPE_BIGINTEGER,
                        'unsigned' => true,
                        'notNull' => false,
                        'size' => 1,
                        'comment' => "The user being impersonated (if any)",
                        'after' => 'created_by'
                    ]
                ),
            ],
            'indexes' => [
                new Index('PRIMARY', ['id'], 'PRIMARY'),
                new Index('uuid_UNIQUE', ['uuid'], 'UNIQUE'),
                new Index('idx_audited_record', ['table', 'primary'], ''),
                new Index('idx_created_by', ['created_by'], ''),
                new Index('fk_audit_created_as', ['created_as'], ''),
            ],
            'references' => [
                new Reference(
                    'fk_audit_created_as',
                    [
                        'referencedSchema' => 'phalcon_kit',
                        'referencedTable' => 'user',
                        'columns' => ['created_as'],
                        'referencedColumns' => ['id'],
                        'onUpdate' => 'CASCADE',
                        'onDelete' => 'SET NULL'
                    ]
                ),
                new Reference(
                    'fk_audit_created_by',
                    [
                        'referencedSchema' => 'phalcon_kit',
                        'referencedTable' => 'user',
                        'columns' => ['created_by'],
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
