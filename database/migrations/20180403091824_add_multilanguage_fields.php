<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class AddMultilanguageFields extends AbstractMigration
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
        $pagecontent = $this->table('page_contents');
        $pagecontent
        ->addColumn('title', 'string', ['limit' => 255])
        ->addColumn('seo_title', 'string', ['limit' => 255])
        ->addColumn('seo_description', 'string', ['limit' => MysqlAdapter::TEXT_MEDIUM])
        ->update();
    }
}
