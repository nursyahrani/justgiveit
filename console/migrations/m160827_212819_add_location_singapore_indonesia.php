<?php

use yii\db\Migration;

class m160827_212819_add_location_singapore_indonesia extends Migration
{
    public function up()
    {
        $timestamp = time();
    
        $this->execute("INSERT INTO country(country_code, country_default_name, created_at, updated_at) values('SG', 'Singapore', $timestamp , $timestamp);");
        
        $this->execute("INSERT INTO country(country_code, country_default_name, created_at, updated_at) values('ID', 'Indonesia', $timestamp, $timestamp);");
    
        $this->execute("INSERT INTO region(country_code, region_name, created_at, updated_at) values('SG', 'Singapore', $timestamp, $timestamp);");
        $this->execute("INSERT INTO city(city_name, region_name, country_code, created_at, updated_at) values('{empty}', 'Singapore', 'SG', $timestamp, $timestamp);"); 
    }

    public function down()
    {
        echo "m160827_212819_add_location_singapore_indonesia cannot be reverted.\n";

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
