<?php

use yii\db\Migration;

class m160906_093332_add_status_to_post extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE post add post_status int(6) not null default 10");
    }

    public function down()
    {
        echo "m160906_093332_add_status_to_post cannot be reverted.\n";

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
