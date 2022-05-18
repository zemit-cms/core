<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class UserMigration_100
 */
class UserMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('user', [
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
                        'email',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => false,
                            'size' => 255,
                            'after' => 'id'
                        ]
                    ),
                    new Column(
                        'username',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => false,
                            'size' => 120,
                            'after' => 'email'
                        ]
                    ),
                    new Column(
                        'mfa',
                        [
                            'type' => Column::TYPE_TINYINTEGER,
                            'default' => "0",
                            'unsigned' => true,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'username'
                        ]
                    ),
                    new Column(
                        'mfa_secret',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => false,
                            'size' => 255,
                            'after' => 'mfa'
                        ]
                    ),
                    new Column(
                        'token',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => false,
                            'size' => 120,
                            'after' => 'mfa_secret'
                        ]
                    ),
                    new Column(
                        'password',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => false,
                            'size' => 255,
                            'after' => 'token'
                        ]
                    ),
                    new Column(
                        'password_confirm',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => false,
                            'size' => 255,
                            'after' => 'password'
                        ]
                    ),
                    new Column(
                        'salt',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => false,
                            'size' => 255,
                            'after' => 'password_confirm'
                        ]
                    ),
                    new Column(
                        'first_name',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 120,
                            'after' => 'salt'
                        ]
                    ),
                    new Column(
                        'last_name',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 120,
                            'after' => 'first_name'
                        ]
                    ),
                    new Column(
                        'gender',
                        [
                            'type' => Column::TYPE_TINYINTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 1,
                            'after' => 'last_name'
                        ]
                    ),
                    new Column(
                        'dob',
                        [
                            'type' => Column::TYPE_DATE,
                            'notNull' => false,
                            'after' => 'gender'
                        ]
                    ),
                    new Column(
                        'title',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => false,
                            'size' => 120,
                            'after' => 'dob'
                        ]
                    ),
                    new Column(
                        'phone',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => false,
                            'size' => 60,
                            'after' => 'title'
                        ]
                    ),
                    new Column(
                        'phone2',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => false,
                            'size' => 60,
                            'after' => 'phone'
                        ]
                    ),
                    new Column(
                        'cellphone',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => false,
                            'size' => 60,
                            'after' => 'phone2'
                        ]
                    ),
                    new Column(
                        'fax',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => false,
                            'size' => 60,
                            'after' => 'cellphone'
                        ]
                    ),
                    new Column(
                        'status',
                        [
                            'type' => Column::TYPE_ENUM,
                            'default' => "new",
                            'notNull' => false,
                            'size' => "'new','pending','approved','not_approved'",
                            'after' => 'fax'
                        ]
                    ),
                    new Column(
                        'category',
                        [
                            'type' => Column::TYPE_ENUM,
                            'default' => "other",
                            'notNull' => true,
                            'size' => "'company','employee','other','banned','guest'",
                            'after' => 'status'
                        ]
                    ),
                    new Column(
                        'language',
                        [
                            'type' => Column::TYPE_ENUM,
                            'default' => "fr",
                            'notNull' => true,
                            'size' => "'fr','en'",
                            'after' => 'category'
                        ]
                    ),
                    new Column(
                        'newsletter',
                        [
                            'type' => Column::TYPE_TINYINTEGER,
                            'default' => "0",
                            'unsigned' => true,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'language'
                        ]
                    ),
                    new Column(
                        'company_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 1,
                            'after' => 'newsletter'
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
                            'after' => 'company_id'
                        ]
                    ),
                    new Column(
                        'created_at',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'default' => "CURRENT_TIMESTAMP",
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
                        'deleted_as',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 1,
                            'after' => 'deleted_at'
                        ]
                    ),
                    new Column(
                        'deleted_by',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => false,
                            'size' => 1,
                            'after' => 'deleted_as'
                        ]
                    ),
                    new Column(
                        'restored_at',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'notNull' => false,
                            'after' => 'deleted_by'
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
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id'], 'PRIMARY'),
                    new Index('id_UNIQUE', ['id'], 'UNIQUE'),
                    new Index('email', ['email'], ''),
                    new Index('username', ['username'], ''),
                    new Index('token', ['token'], ''),
                    new Index('company_id', ['company_id'], ''),
                    new Index('created_by', ['created_by'], ''),
                    new Index('created_as', ['created_as'], ''),
                    new Index('updated_by', ['updated_by'], ''),
                    new Index('updated_as', ['updated_as'], ''),
                    new Index('deleted_by', ['deleted_by'], ''),
                    new Index('deleted_as', ['deleted_as'], ''),
                    new Index('restored_by', ['restored_by'], ''),
                    new Index('restored_as', ['restored_as'], '')
                ],
                'options' => [
                    'table_type' => 'BASE TABLE',
                    'auto_increment' => '',
                    'engine' => 'InnoDB',
                    'table_collation' => 'utf8_general_ci'
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
