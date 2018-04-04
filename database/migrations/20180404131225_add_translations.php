<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class AddTranslations extends AbstractMigration
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
        $language = $this->table('translations');
        $language
        ->addColumn('language_id', 'integer')
        ->addColumn('key', 'string', ['limit' => 100])
        ->addColumn('value', 'string', ['limit' => MysqlAdapter::TEXT_MEDIUM])
        ->addForeignKey('language_id', 'languages', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
        ->create();

        $permissionRows = [
            ['id' => 40, 'permission_name' => 'View Translations'],
            ['id' => 41, 'permission_name' => 'Add Translations'],
            ['id' => 42, 'permission_name' => 'Edit Translations'],
            ['id' => 43, 'permission_name' => 'Delete Translations']
        ];
   
        $this->insert('permissions', $permissionRows);
    }
}
