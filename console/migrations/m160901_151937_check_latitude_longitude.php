<?php

use yii\db\Migration;

class m160901_151937_check_latitude_longitude extends Migration
{
    public function up()
    {
        $this->execute("CREATE TABLE ll (id int not null primary key auto_increment, "
                . "latitude varchar(255) not null, "
                . "longitude varchar(255) not null, "
                . "created_at int not null, "
                . "updated_at int not null); ");
    }

    public function down()
    {
        echo "m160901_151937_check_latitude_longitude cannot be reverted.\n";

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
