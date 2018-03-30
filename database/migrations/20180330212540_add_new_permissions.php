<?php


use Phinx\Migration\AbstractMigration;

class AddNewPermissions extends AbstractMigration
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
      $permissionRows = [
         ['id' => 30, 'permission_name' => 'Add new Language'],
         ['id' => 31, 'permission_name' => 'Edit Language'],
         ['id' => 32, 'permission_name' => 'Delete Language'],
         ['id' => 33, 'permission_name' => 'View Languages'],
         ['id' => 34, 'permission_name' => 'View Pages'],
         ['id' => 35, 'permission_name' => 'View Media'],
         ['id' => 36, 'permission_name' => 'View Menus'],
         ['id' => 37, 'permission_name' => 'View Themes'],
         ['id' => 38, 'permission_name' => 'View Settings'],
         ['id' => 39, 'permission_name' => 'View Pagebuilder Items']
     ];

     $this->insert('permissions', $permissionRows);
    }
}
