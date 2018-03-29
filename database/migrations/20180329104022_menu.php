<?php


use Phinx\Migration\AbstractMigration;

class Menu extends AbstractMigration
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
        $menu = $this->table('menus');
        $menu
        ->addColumn('name', 'string', ['limit' => 255])
        ->addIndex(['name'], ['unique' => true])
        ->create();

        $menuitem = $this->table('menu_items');
        $menuitem
        ->addColumn('name', 'string', ['limit' => 255])
        ->addColumn('menu_position', 'integer')
        ->addColumn('menu_id', 'integer')
        ->addColumn('page_id', 'integer')
        ->addForeignKey('menu_id', 'menus', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
        ->addForeignKey('page_id', 'pages', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
        ->create();
    }
}
