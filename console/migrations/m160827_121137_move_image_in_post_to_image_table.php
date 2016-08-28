<?php

use yii\db\Migration;

class m160827_121137_move_image_in_post_to_image_table extends Migration
{
    public function up()
    {
        $this->execute(""
                . ""
                . "INSERT INTO image(user_id, image_path)"
                . "SELECT poster_id,photo_path from post");
        
        

    }

    public function down()
    {
        echo "m160827_121137_move_image_in_post_to_image_table cannot be reverted.\n";

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
