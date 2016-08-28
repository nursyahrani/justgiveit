<?php

use yii\db\Migration;

class m160827_123805_drop_photo_path_in_post extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE post drop column photo_path");

    }

    public function down()
    {
        echo "m160827_123805_drop_photo_path_in_post cannot be reverted.\n";

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
