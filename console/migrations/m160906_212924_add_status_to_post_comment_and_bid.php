<?php

use yii\db\Migration;

class m160906_212924_add_status_to_post_comment_and_bid extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE post_comment add post_comment_status int not null default 10");
        $this->execute("ALTER TABLE bid add bid_status int not null default 10");
    }

    public function down()
    {
        echo "m160906_212924_add_status_to_post_comment_and_bid cannot be reverted.\n";

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
