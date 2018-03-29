<?php


use Phinx\Migration\AbstractMigration;

class Permission extends AbstractMigration
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
        $permission = $this->table('permissions');
        $permission->addColumn('permission_name', 'string', ['limit' => 255])
        ->create();

        $permissionRows = [
            ['id' => 1, 'permission_name' => 'Add new Pages'],
            ['id' => 4, 'permission_name' => 'Edit Pages'],
            ['id' => 5, 'permission_name' => 'Delete Pages'],
            ['id' => 6, 'permission_name' => 'Upload Media Files/Folders'],
            ['id' => 7, 'permission_name' => 'Edit Media Files/Folders'],
            ['id' => 8, 'permission_name' => 'Delete Media Files/Folders'],
            ['id' => 9, 'permission_name' => 'Add new Menu'],
            ['id' => 10, 'permission_name' => 'Edit Menu'],
            ['id' => 11, 'permission_name' => 'Delete Menu'],
            ['id' => 15, 'permission_name' => 'Add new Theme'],
            ['id' => 16, 'permission_name' => 'Edit Theme'],
            ['id' => 17, 'permission_name' => 'Delete Theme'],
            ['id' => 18, 'permission_name' => 'Change Settings'],
            ['id' => 19, 'permission_name' => 'Add new Pagebuilder Item'],
            ['id' => 20, 'permission_name' => 'Edit Pagebuilder Item'],
            ['id' => 21, 'permission_name' => 'Delete Pagebuilder Item'],
            ['id' => 22, 'permission_name' => 'View User Roles'],
            ['id' => 23, 'permission_name' => 'Add User Roles'],
            ['id' => 24, 'permission_name' => 'Edit User Roles'],
            ['id' => 25, 'permission_name' => 'Delete User Roles'],
            ['id' => 26, 'permission_name' => 'Add Users'],
            ['id' => 27, 'permission_name' => 'Edit Users'],
            ['id' => 28, 'permission_name' => 'Delete Users'],
            ['id' => 29, 'permission_name' => 'View Users']
        ];

        $this->insert('permissions', $permissionRows);

        $userrolepermissions = $this->table('user_role_permissions', ['id' => false, 'primary_key' => ['user_role_id', 'permission_id']]);
        $userrolepermissions->addColumn('user_role_id', 'integer')
        ->addColumn('permission_id', 'integer')
        ->create();

        $userPermissionRows = [
            ['user_role_id' => 1, 'permission_id' => 1],
            ['user_role_id' => 1, 'permission_id' => 2],
            ['user_role_id' => 1, 'permission_id' => 3],
            ['user_role_id' => 1, 'permission_id' => 4],
            ['user_role_id' => 1, 'permission_id' => 5],
            ['user_role_id' => 1, 'permission_id' => 6],
            ['user_role_id' => 1, 'permission_id' => 7],
            ['user_role_id' => 1, 'permission_id' => 8],
            ['user_role_id' => 1, 'permission_id' => 9],
            ['user_role_id' => 1, 'permission_id' => 10],
            ['user_role_id' => 1, 'permission_id' => 11],
            ['user_role_id' => 1, 'permission_id' => 15],
            ['user_role_id' => 1, 'permission_id' => 16],
            ['user_role_id' => 1, 'permission_id' => 17],
            ['user_role_id' => 1, 'permission_id' => 18],
            ['user_role_id' => 1, 'permission_id' => 19],
            ['user_role_id' => 1, 'permission_id' => 20],
            ['user_role_id' => 1, 'permission_id' => 21],
            ['user_role_id' => 1, 'permission_id' => 22],
            ['user_role_id' => 1, 'permission_id' => 23],
            ['user_role_id' => 1, 'permission_id' => 24],
            ['user_role_id' => 1, 'permission_id' => 25],
            ['user_role_id' => 1, 'permission_id' => 26],
            ['user_role_id' => 1, 'permission_id' => 27],
            ['user_role_id' => 1, 'permission_id' => 28],
            ['user_role_id' => 1, 'permission_id' => 29]
        ];

        $this->insert('user_role_permissions', $userPermissionRows);
    }
}
