<?php

use Phinx\Migration\AbstractMigration;

class Queue extends AbstractMigration
{
    /**
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
        $table = $this->table('wuv_queue_items');
        $table->addColumn('urlAddress', 'string', [
            'length' => 254,
            'null'   => false,
        ]);

        $table->addColumn('state', 'string', [
            'length'  => 16,
            'null'    => false,
            'default' => 'queued',
        ]);

        $table->addColumn('type', 'string', [
            'length'  => 16,
            'null'    => false,
            'default' => 'Url',
        ]);

        $table->addColumn('dateAdded', 'datetime', [
            'null' => false,
        ]);

        $table->addIndex(['urlAddress'], ['unique' => true]);
        $table->addIndex(['state']);

        $table->create();
    }
}
