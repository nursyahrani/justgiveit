<?php

use yii\db\Migration;

class m160909_061551_add_notif_last_seen_to_user_table extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE user add notif_last_seen int not null default 0");

    }

    public function down()
    {
        echo "m160909_061551_add_notif_last_seen_to_user_table cannot be reverted.\n";

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
