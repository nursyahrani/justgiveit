<?php

use yii\db\Migration;

class m160815_105432_drop_table_message_create_table_bid extends Migration
{
    public function up()
    {
        $this->execute("DROP TABLE message; ");
        $this->execute("CREATE TABLE bid("
                . "stuff_id int not null,"
                . "proposer_id int not null,"
                . "message text not null,"
                . "created_at int not null,"
                . "updated_at int not null,"
                . "primary key(stuff_id, proposer_id),"
                . "foreign key(stuff_id) references post(stuff_id),"
                . "foreign key(proposer_id) references user(id)"
                . ");");
    }

    public function down()
    {
        echo "m160815_105432_drop_table_message_create_table_bid cannot be reverted.\n";

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
