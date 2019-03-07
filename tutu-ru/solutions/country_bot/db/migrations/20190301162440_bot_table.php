<?php


use Phinx\Migration\AbstractMigration;

class BotTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     */
    public function change()
    {
        // create the table
        $table = $this->table('bot_countries');
        $table->addColumn('code', 'string')
            ->addColumn('name_ru', 'string')
            ->addColumn('name_en', 'string')
            ->addColumn('wiki_link', 'text')
            ->create();
    }
}
