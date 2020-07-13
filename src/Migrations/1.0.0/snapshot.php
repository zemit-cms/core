<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class SnapshotMigration_100
 */
class SnapshotMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('snapshot', [
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
                        'snapshot_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 10,
                            'after' => 'id'
                        ]
                    ),
                    new Column(
                        'project_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 10,
                            'after' => 'snapshot_id'
                        ]
                    ),
                    new Column(
                        'channel_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 10,
                            'after' => 'project_id'
                        ]
                    ),
                    new Column(
                        'endpoint_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 10,
                            'after' => 'channel_id'
                        ]
                    ),
                    new Column(
                        'snapshot',
                        [
                            'type' => Column::TYPE_LONGTEXT,
                            'notNull' => true,
                            'after' => 'endpoint_id'
                        ]
                    ),
                    new Column(
                        'meta',
                        [
                            'type' => Column::TYPE_LONGTEXT,
                            'notNull' => false,
                            'after' => 'snapshot'
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
                        'deleted',
                        [
                            'type' => Column::TYPE_TINYINTEGER,
                            'default' => "0",
                            'unsigned' => true,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'deleted_at'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id'], 'PRIMARY'),
                    new Index('id_UNIQUE', ['id'], 'UNIQUE'),
                    new Index('snapshot_snapshot_id_fk_idx', ['snapshot_id'], ''),
                    new Index('snapshot_project_id_fk_idx', ['project_id'], ''),
                    new Index('snapshot_channel_id_fk_idx', ['channel_id'], ''),
                    new Index('snapshot_endpoint_id_fk_idx', ['endpoint_id'], '')
                ],
                'references' => [
                    new Reference(
                        'snapshot_channel_id_fk',
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
                        'snapshot_endpoint_id_fk',
                        [
                            'referencedTable' => 'endpoint',
                            'referencedSchema' => 'zemit',
                            'columns' => ['endpoint_id'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'CASCADE',
                            'onDelete' => 'CASCADE'
                        ]
                    ),
                    new Reference(
                        'snapshot_project_id_fk',
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
                        'snapshot_snapshot_id_fk',
                        [
                            'referencedTable' => 'snapshot',
                            'referencedSchema' => 'zemit',
                            'columns' => ['snapshot_id'],
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
