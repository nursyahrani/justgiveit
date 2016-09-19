<?php

use yii\db\Migration;

class m160919_103356_add_intro_to_user extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE user add intro varchar(255) null");
    }

    public function down()
    {
        echo "m160919_103356_add_intro_to_user cannot be reverted.\n";

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
