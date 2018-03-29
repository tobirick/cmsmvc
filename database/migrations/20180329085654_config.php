<?php


use Phinx\Migration\AbstractMigration;

class Config extends AbstractMigration
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
        $config = $this->table('config');
        $config
        ->addColumn('name', 'string', ['limit' => 255])
        ->addColumn('value', 'string', ['limit' => 255])
        ->addIndex(['name'], ['unique' => true])
        ->create();

        $configRows = [
            ['id' => 1, 'name' => 'active_theme_id', 'value' => '1'],
            ['id' => 2, 'name' => 'active_menu_id', 'value' => '0'],
            ['id' => 3, 'name' => 'active_footer_menu_id', 'value' => '0'],
            ['id' => 4, 'name' => 'siteurl', 'value' => ''],
            ['id' => 5, 'name' => 'sitetitle', 'value' => ''],
            ['id' => 6, 'name' => 'sitedescription', 'value' => ''],
            ['id' => 7, 'name' => 'sitesubtitle', 'value' => ''],
            ['id' => 8, 'name' => 'home_page_id', 'value' => '1']
        ];

        $this->insert('config', $configRows);
    }
}
