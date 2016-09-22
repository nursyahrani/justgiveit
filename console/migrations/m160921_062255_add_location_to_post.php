<?php

use yii\db\Migration;

class m160921_062255_add_location_to_post extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE post add pick_up_location_id int not null");
        $this->execute("UPDATE user, post
                        SET post.pick_up_location_id = user.city_id
                        where user.id = post.poster_id ");
        
        $this->execute("ALTER TABLE post add Foreign Key(pick_up_location_id) references city(city_id)");
    }

    public function down()
    {
        echo "m160921_062255_add_location_to_post cannot be reverted.\n";

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
