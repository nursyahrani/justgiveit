<?php

use yii\db\Migration;

class m160822_230809_bid_add_obtain_stuff_column extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE bid add obtain boolean not null default false;"
                . "ALTER TABLE bid add confirm boolean not null default false;");
    }

    public function down()
    {
        echo "m160822_230809_bid_add_obtain_stuff_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
