<?php

use yii\db\Migration;

class m160827_211150_add_location extends Migration
{
    public function up()
    {
        $this->execute("CREATE TABLE country("
                . "country_code varchar(20) not null primary key,"
                . "country_default_name varchar(120) not null,"
                . "country_flag varchar(255) null,"
                . "created_at int not null,"
                . "updated_at int not null"
                . ")");
                
        $this->execute("CREATE TABLE region("
                . "country_code varchar(20) not null,"
                . "region_name varchar(120) not null,"
                . "created_at int not null,"
                . "updated_at int not null,"
                . "primary key(country_code, region_name),"
                . "foreign key(country_code) references country(country_code));");
        
        $this->execute("CREATE TABLE city("
                . "city_id int not null auto_increment primary key,"
                . "city_name varchar(250) not null,"
                . "region_name varchar(120) not null,"
                . "country_code varchar(20) not null,"
                . "created_at int not null,"
                . "updated_at int not null,"
                . "foreign key(country_code, region_name) references region(country_code, region_name))");
    }

    public function down()
    {
        echo "m160827_211150_add_location cannot be reverted.\n";

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
