<?php

use yii\db\Migration;

class m160828_141706_set_default_location_to_all_users extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE city AUTO_INCREMENT = 1");
        $this->execute("INSERT INTO city(country_code, city_name) values('SG', 'Singapore (Western Water Catchment)')");
        $this->execute("UPDATE user"
                . " SET user.city_id = 1 "
                . "WHERE user.city_id is null");
        
    }

    public function down()
    {
        echo "m160828_141706_set_default_location_to_all_users cannot be reverted.\n";

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
