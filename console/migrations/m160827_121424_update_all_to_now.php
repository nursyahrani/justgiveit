<?php

use yii\db\Migration;

class m160827_121424_update_all_to_now extends Migration
{
    public function up()
    {
        $timestamp = time();
        $this->execute("UPDATE image set created_at = " . $timestamp);
        
        $this->execute("UPDATE image set updated_at = " . $timestamp);
    }

    public function down()
    {
        echo "m160827_121424_update_all_to_now cannot be reverted.\n";

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
