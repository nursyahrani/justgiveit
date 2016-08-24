<?php

use yii\db\Migration;

class m160822_092710_post_give_table extends Migration
{
    public function up()
    {
        $this->execute(""
                . "CREATE TABLE post_give("
                . "stuff_id int not null,"
                . "user_id int not null,"
                . "created_at int not null,"
                . "updated_at int not null,"
                . "foreign key (user_id) references user(id),"
                . "foreign key (stuff_id) references post(stuff_id)"
                . ""
                . ");"
                . "");
    }

    public function down()
    {
        echo "m160822_092710_post_give_table cannot be reverted.\n";

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
