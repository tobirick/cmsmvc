<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class Language extends AbstractMigration
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
      $language = $this->table('languages');
      $language
      ->addColumn('name', 'string', ['limit' => 100])
      ->addColumn('iso', 'string', ['limit' => 10])
      ->addColumn('is_active', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'default' => 1])
      ->create();

      $languageRows = [
         ['name' => 'English', 'iso' => 'en'],
         ['name' => 'Deutsch', 'iso' => 'de']
      ];
      $this->insert('languages', $languageRows);

      $configRows = [
         ['name' => 'default_language_id', 'value' => 1]
      ];
     $this->insert('config', $configRows);

     $pagecontent = $this->table('page_contents');
     $pagecontent
     ->addColumn('page_id', 'integer')
     ->addColumn('language_id', 'integer')
     ->addColumn('content', 'string', ['limit' => MysqlAdapter::TEXT_LONG])
     ->addForeignKey('page_id', 'pages', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
     ->addForeignKey('language_id', 'languages', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
     ->create();

     $pagebuildersections = $this->table('pagebuilder_sections');
     $pagebuildersections
     ->addColumn('language_id', 'integer')
     ->addIndex(['language_id'])
     ->addForeignKey('language_id', 'languages', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
     ->update();
    }
}
