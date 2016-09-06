<?php

use yii\db\Migration;

class m160904_114156_delete_ship_preference extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE post drop column delivery; ALTER TABLE post drop column meet_up; drop table pick_up_location; drop table ll;");

    }

    public function down()
    {
        echo "m160904_114156_delete_ship_preference cannot be reverted.\n";

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
