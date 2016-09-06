<?php

use yii\db\Migration;

/**
 * Handles the creation for table `pick_up_location`.
 */
class m160903_113528_create_pick_up_location_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->execute("CREATE TABLE pick_up_location ("
                . "pick_up_location_id int not null primary key,"
                . "address text not null,"
                . "longitude float null,"
                . "altitude float null,"
                . "user_id int not null,"
                . "foreign key(user_id) references user(id))");
        
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('pick_up_location');
    }
}
