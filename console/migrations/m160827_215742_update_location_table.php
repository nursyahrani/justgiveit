<?php

use yii\db\Migration;

class m160827_215742_update_location_table extends Migration
{
    public function up()
    {
        $this->execute('DROP TABLE city;');
        $this->execute('DROP TABLE region;');
        $this->execute("CREATE table city ("
                . "city_id int not null auto_increment primary key,"
                . "city_name varchar(250) not null,"
                . "country_code varchar(20) not null,"
                . "created_at int not null,"
                . "updated_at int not null,"
                . "foreign key(country_code) references country(country_code)) ");
    }

    public function down()
    {
        echo "m160827_215742_update_location_table cannot be reverted.\n";

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
