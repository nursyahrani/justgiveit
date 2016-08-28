<?php

use yii\db\Migration;

class m160827_220118_add_city_to_user extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE user add city_id int null;");
        $this->execute("ALTER TABLE user add foreign key(city_id) references city(city_id);");
        $this->execute("ALTER TABLE user add location_confirmation boolean not null default 0");
    }

    public function down()
    {
        echo "m160827_220118_add_city_to_user cannot be reverted.\n";

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
