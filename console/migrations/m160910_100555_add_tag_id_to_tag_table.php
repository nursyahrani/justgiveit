<?php

use yii\db\Migration;

class m160910_100555_add_tag_id_to_tag_table extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE tag add tag_id int not null auto_increment unique");
    }

    public function down()
    {
        echo "m160910_100555_add_tag_id_to_tag_table cannot be reverted.\n";

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
