<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class Theme extends AbstractMigration
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
        $theme = $this->table('themes');
        $theme
        ->addColumn('name', 'string', ['limit' => 255])
        ->addColumn('path', 'string', ['limit' => 255])
        ->addColumn('logo', 'string', ['limit' => 255])
        ->addColumn('favicon', 'string', ['limit' => 255])
        ->addColumn('fixed_navigation', 'integer', ['limit' => MysqlAdapter::INT_TINY])
        ->addColumn('to_top', 'integer', ['limit' => MysqlAdapter::INT_TINY])
        ->addColumn('google_analytics', 'string', ['limit' => MysqlAdapter::TEXT_MEDIUM])
        ->addColumn('header_code', 'string', ['limit' => MysqlAdapter::TEXT_MEDIUM])
        ->addColumn('body_code', 'string', ['limit' => MysqlAdapter::TEXT_MEDIUM])
        ->addColumn('header_layout', 'string', ['limit' => MysqlAdapter::TEXT_MEDIUM])
        ->addColumn('footer_layout', 'string', ['limit' => MysqlAdapter::TEXT_MEDIUM])
        ->addColumn('google_font', 'string', ['limit' => 255])
        ->addColumn('custom_scripts', 'string', ['limit' => MysqlAdapter::TEXT_MEDIUM])
        ->addColumn('custom_styles', 'string', ['limit' => MysqlAdapter::TEXT_MEDIUM])
        ->addColumn('font_styles', 'string', ['limit' => MysqlAdapter::TEXT_MEDIUM])
        ->addColumn('default_color', 'string', ['limit' => 255])
        ->addIndex(['name', 'path'], ['unique' => true])
        ->create();

        $themeRows = [
            ['id' => 1, 'name' => 'trtheme', 'path' => 'App/Views/public/themes/trtheme']
        ];

        $this->insert('themes', $themeRows);
    }
}
