<?php


use Phinx\Migration\AbstractMigration;

class ChangeBotCountryPrimary extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('bot_countries');
        $table
            ->changePrimaryKey('code')
            ->removeColumn('id')
            ->save();
    }

    public function down()
    {
        $table = $this->table('bot_countries');
        $table
            ->addColumn('id','integer')
            ->changePrimaryKey('id')
            ->save();
    }
}
