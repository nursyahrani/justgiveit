<?php

use yii\db\Migration;

class m160909_033036_alter_table_notification_created_at_updated_at extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE notification add created_at int not null; ALTER TABLE notification add updated_at int not null;");
    }

    public function down()
    {
        echo "m160909_033036_alter_table_notification_created_at_updated_at cannot be reverted.\n";

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
