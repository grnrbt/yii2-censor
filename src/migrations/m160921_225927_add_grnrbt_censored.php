<?php

use yii\db\Migration;

class m160921_225927_add_grnrbt_censored extends Migration
{
    private $table = 'grnrbt_censored';
    private $pk = 'grnrbt_censored_pkey';

    public function safeUp()
    {
        $this->createTable($this->table, [
            'pattern' => $this->string(255)->notNull(),
        ]);
        $this->addPrimaryKey($this->pk, $this->table, 'pattern');
    }

    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
