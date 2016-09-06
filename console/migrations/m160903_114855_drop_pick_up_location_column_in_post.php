<?php

use yii\db\Migration;

class m160903_114855_drop_pick_up_location_column_in_post extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE post drop column pick_up_location_id");
    }

    public function down()
    {
        echo "m160903_114855_drop_pick_up_location_column_in_post cannot be reverted.\n";

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
