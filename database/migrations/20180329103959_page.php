<?php


use Phinx\Migration\AbstractMigration;

class Page extends AbstractMigration
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
        $page = $this->table('pages');
        $page
        ->addColumn('name', 'string', ['limit' => 255])
        ->addColumn('slug', 'string', ['limit' => 20])
        ->addColumn('title', 'string', ['limit' => 255])
        ->addColumn('content', 'string', ['limit' => 255])
        ->addColumn('seo_title', 'string', ['limit' => 255])
        ->addColumn('seo_description', 'string', ['limit' => 255])
        ->addColumn('created_at', 'timestamp', ['null' => false, 'default' => '0000-00-00 00:00:00'])
        ->addColumn('updated_at', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
        ->addColumn('created_by', 'integer')
        ->addIndex(['name', 'slug'], ['unique' => true])
        ->create();
    }
}
