<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class Pagebuilder extends AbstractMigration
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
        $pagebuilderitems = $this->table('pagebuilder_items');
        $pagebuilderitems->addColumn('item_name', 'string', ['limit' => 255])
        ->addColumn('item_type', 'string', ['limit' => 255])
        ->addColumn('item_html', 'string', ['limit' => MysqlAdapter::TEXT_LONG])
        ->addColumn('item_json_config', 'string', ['limit' => MysqlAdapter::TEXT_MEDIUM])
        ->create();

        $pagebuildersections = $this->table('pagebuilder_sections');
        $pagebuildersections->addColumn('name', 'string', ['limit' => 255])
        ->addColumn('page_id', 'integer')
        ->addColumn('position', 'integer')
        ->addColumn('css_class', 'string', ['limit' => 255])
        ->addColumn('css_id', 'string', ['limit' => 255])
        ->addColumn('styles', 'string', ['limit' => MysqlAdapter::TEXT_MEDIUM])
        ->addColumn('bg_color', 'string', ['limit' => 255])
        ->addColumn('bg_image', 'string', ['limit' => 255])
        ->addColumn('bg_image_size', 'string', ['limit' => 255])
        ->addColumn('bg_image_position', 'string', ['limit' => 255])
        ->addColumn('bg_image_repeat', 'string', ['limit' => 255])
        ->addColumn('bg_gradient_first_color', 'string', ['limit' => 255])
        ->addColumn('bg_gradient_second_color', 'string', ['limit' => 255])
        ->addColumn('bg_gradient_type', 'string', ['limit' => 255])
        ->addColumn('bg_gradient_direction', 'string', ['limit' => 255])
        ->addColumn('bg_gradient_start_position', 'string', ['limit' => 255])
        ->addColumn('bg_gradient_end_position', 'string', ['limit' => 255])
        ->addColumn('padding', 'string', ['limit' => 255])
        ->addColumn('margin', 'string', ['limit' => 255])
        ->addColumn('current_bg_mode', 'string', ['limit' => 255])
        ->addIndex(['page_id'])
        ->addForeignKey('page_id', 'pages', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
        ->create();

        $pagebuilderrows = $this->table('pagebuilder_rows');
        $pagebuilderrows->addColumn('name', 'string', ['limit' => 255])
        ->addColumn('section_id', 'integer')
        ->addColumn('position', 'integer')
        ->addColumn('css_class', 'string', ['limit' => 255])
        ->addColumn('css_id', 'string', ['limit' => 255])
        ->addColumn('styles', 'string', ['limit' => MysqlAdapter::TEXT_MEDIUM])
        ->addColumn('bg_color', 'string', ['limit' => 255])
        ->addColumn('bg_image', 'string', ['limit' => 255])
        ->addColumn('bg_image_size', 'string', ['limit' => 255])
        ->addColumn('bg_image_position', 'string', ['limit' => 255])
        ->addColumn('bg_image_repeat', 'string', ['limit' => 255])
        ->addColumn('bg_gradient_first_color', 'string', ['limit' => 255])
        ->addColumn('bg_gradient_second_color', 'string', ['limit' => 255])
        ->addColumn('bg_gradient_type', 'string', ['limit' => 255])
        ->addColumn('bg_gradient_direction', 'string', ['limit' => 255])
        ->addColumn('bg_gradient_start_position', 'string', ['limit' => 255])
        ->addColumn('bg_gradient_end_position', 'string', ['limit' => 255])
        ->addColumn('padding', 'string', ['limit' => 255])
        ->addColumn('margin', 'string', ['limit' => 255])
        ->addColumn('current_bg_mode', 'string', ['limit' => 255])
        ->addIndex(['section_id'])
        ->addForeignKey('section_id', 'pagebuilder_sections', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
        ->create();

        $pagebuildercolumnrows = $this->table('pagebuilder_columnrows');
        $pagebuildercolumnrows
        ->addColumn('row_id', 'integer')
        ->addColumn('position', 'integer')
        ->addIndex(['row_id'])
        ->addForeignKey('row_id', 'pagebuilder_rows', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
        ->create();

        $pagebuildercolumns = $this->table('pagebuilder_columns');
        $pagebuildercolumns
        ->addColumn('columnrow_id', 'integer')
        ->addColumn('position', 'integer')
        ->addColumn('col', 'string', ['limit' => 255])
        ->addIndex(['columnrow_id'])
        ->addForeignKey('columnrow_id', 'pagebuilder_columnrows', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
        ->create();

        $pagebuilderelements = $this->table('pagebuilder_elements');
        $pagebuilderelements->addColumn('name', 'string', ['limit' => 255])
        ->addColumn('column_id', 'integer')
        ->addColumn('item_id', 'integer')
        ->addColumn('position', 'integer')
        ->addColumn('css_class', 'string', ['limit' => 255])
        ->addColumn('css_id', 'string', ['limit' => 255])
        ->addColumn('styles', 'string', ['limit' => MysqlAdapter::TEXT_MEDIUM])
        ->addColumn('bg_color', 'string', ['limit' => 255])
        ->addColumn('padding', 'string', ['limit' => 255])
        ->addColumn('margin', 'string', ['limit' => 255])
        ->addColumn('html', 'string', ['limit' => MysqlAdapter::TEXT_LONG])
        ->addColumn('config', 'string', ['limit' => MysqlAdapter::TEXT_MEDIUM])
        ->addIndex(['column_id'])
        ->addForeignKey('column_id', 'pagebuilder_columns', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
        ->create();
    }
}
