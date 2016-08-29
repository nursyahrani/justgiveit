<?php

use yii\db\Migration;

/**
 * Handles the creation for table `bid_reply`.
 */
class m160829_143235_create_bid_reply_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->execute("ALTER TABLE bid ADD bid_id int not null auto_increment unique");
        
        $this->execute("CREATE TABLE bid_reply("
                . "bid_reply_id int not null auto_increment primary key,"
                . "bid_id int not null,"
                . "user_id int not null,"
                . "message text not null,"
                . "created_at int not null,"
                . "updated_at int not null,"
                . "foreign key(bid_id) references bid(bid_id),"
                . "foreign key(user_id) references user(id)"
                . ");");
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('bid_reply');
    }
}
