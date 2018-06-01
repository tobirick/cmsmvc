<?php


use Phinx\Migration\AbstractMigration;

class AddAdminUser extends AbstractMigration
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
        $user = [
            ['email' => 'admin@admin.de', 'password_hash' => '$2y$10$dv0yB5NTz.4Jdrcn8iodf.UiZJe3yheKLTNI1bsR32nVpQLeP7QfK', 'name' => 'Admin', 'user_role_id' => 1]
        ];

        $userPermissionRows = [
            ['user_role_id' => 1, 'permission_id' => 30],
            ['user_role_id' => 1, 'permission_id' => 31],
            ['user_role_id' => 1, 'permission_id' => 32],
            ['user_role_id' => 1, 'permission_id' => 33],
            ['user_role_id' => 1, 'permission_id' => 34],
            ['user_role_id' => 1, 'permission_id' => 35],
            ['user_role_id' => 1, 'permission_id' => 36],
            ['user_role_id' => 1, 'permission_id' => 37],
            ['user_role_id' => 1, 'permission_id' => 38],
            ['user_role_id' => 1, 'permission_id' => 39],
            ['user_role_id' => 1, 'permission_id' => 40],
            ['user_role_id' => 1, 'permission_id' => 41],
            ['user_role_id' => 1, 'permission_id' => 42],
            ['user_role_id' => 1, 'permission_id' => 43]
        ];

        $this->insert('users', $user);
        $this->insert('user_role_permissions', $userPermissionRows);
    }
}
