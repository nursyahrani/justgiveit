<?php

use yii\db\Migration;

class m160906_083551_add_auto_increment_to_comment_id extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE post_comment MODIFY COLUMN comment_id int not null auto_increment");
    }

    public function down()
    {
        echo "m160906_083551_add_auto_increment_to_comment_id cannot be reverted.\n";

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
