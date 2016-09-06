<?php

use yii\db\Migration;

class m160901_150248_check_ip extends Migration
{
    public function up()
    {
        $this->execute("CREATE TABLE check_ip( check_ip_id int not null primary key auto_increment, ip varchar(255) not null )");
    }

    public function down()
    {
        echo "m160901_150248_check_ip cannot be reverted.\n";

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
