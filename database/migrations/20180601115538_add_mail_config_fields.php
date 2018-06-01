<?php


use Phinx\Migration\AbstractMigration;

class AddMailConfigFields extends AbstractMigration
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
        $configRows = [
            ['name' => 'from_mail', 'value' => ''],
            ['name' => 'to_mail', 'value' => '']
        ];

        $this->insert('config', $configRows);
    }
}
