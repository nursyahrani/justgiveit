<?php

use yii\db\Migration;

class m160808_073631_update_table_post_created_at_updated_at extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE post drop column updated_at;ALTER TABLE post drop column created_at;");
        $this->execute("ALTER TABLE post add updated_at int not null; ALTER TABLE post add created_at int not null;");

    }

    public function down()
    {
        echo "m160808_073631_update_table_post_created_at_updated_at cannot be reverted.\n";

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
