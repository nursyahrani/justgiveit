<?php

use yii\db\Migration;

class m160904_200626_change_post_give_to_bid_accept extends Migration
{
    public function up()
    {
        $this->execute("DROP TABLE post_give");
    }

    public function down()
    {
        echo "m160904_200626_change_post_give_to_bid_accept cannot be reverted.\n";

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
