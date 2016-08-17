<?php

use yii\db\Migration;

class m160815_105807_create_table_favorite extends Migration
{
    public function up()
    {
        $this->execute("CREATE TABLE favorite("
                . "user_id int not null,"
                . "stuff_id int not null,"
                . "created_at int not null,"
                . "updated_at int not null,"
                . "primary key(user_id, stuff_id),"
                . "foreign key(user_id) references user(id),"
                . "foreign key(stuff_id) references post(stuff_id)"
                . ")");
    }

    public function down()
    {
        echo "m160815_105807_create_table_favorite cannot be reverted.\n";

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
