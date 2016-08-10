<?php

use yii\db\Migration;

class m160807_181929_update_table_post extends Migration
{
    public function up()
    {
        $this->execute(""
                . "ALTER TABLE post drop column type;Alter table post drop column address;"
                . "ALTER TABLE post add deadline int not null;");
                
    }

    public function down()
    {
        echo "m160807_181929_update_table_post cannot be reverted.\n";

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
