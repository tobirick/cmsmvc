<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class UserRole extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $userrole = $this->table('user_roles');
        $userrole
        ->addColumn('user_role_name', 'string', ['limit' => 255])
        ->addColumn('is_admin', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'default' => 0])
        ->create();

        $rows = [
            [
              'id'    => 1,
              'user_role_name'  => 'Admin',
              'is_admin' => 1
            ],
            [
              'id'    => 2,
              'user_role_name'  => 'Subscriber',
              'is_admin' => 0
            ]
        ];

        $this->insert('user_roles', $rows);
    }
}
