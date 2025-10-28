<?php

use Phalcon\Db\Column;
use Phalcon\Db\Exception;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class LogMigration_100
 */
class LogMigration_100 extends Migration
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
        $this->morphTable('log', [
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
                    'level',
                    [
                        'type' => Column::TYPE_INTEGER,
                        'default' => "0",
                        'notNull' => true,
                        'size' => 1,
                        'after' => 'uuid'
                    ]
                ),
                new Column(
                    'type',
                    [
                        'type' => Column::TYPE_ENUM,
                        'default' => "other",
                        'notNull' => true,
                        'size' => "'critical','alert','error','warning','notice','info','debug','emergency','other'",
                        'after' => 'level'
                    ]
                ),
                new Column(
                    'message',
                    [
                        'type' => Column::TYPE_TEXT,
                        'notNull' => true,
                        'after' => 'type'
                    ]
                ),
                new Column(
                    'context',
                    [
                        'type' => Column::TYPE_LONGTEXT,
                        'notNull' => false,
                        'after' => 'message'
                    ]
                ),
                new Column(
                    'created_at',
                    [
                        'type' => Column::TYPE_DATETIME,
                        'default' => "current_timestamp()",
                        'notNull' => true,
                        'after' => 'context'
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
                new Index('idx_type_level', ['type', 'level'], ''),
                new Index('fk_log_created_by', ['created_by'], ''),
            ],
            'references' => [
                new Reference(
                    'fk_log_created_by',
                    [
                        'referencedSchema' => 'zemit_core',
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
