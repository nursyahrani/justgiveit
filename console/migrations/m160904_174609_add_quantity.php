<?php

use yii\db\Migration;

class m160904_174609_add_quantity extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE bid add quantity int not null ");
    }

    public function down()
    {
        echo "m160904_174609_add_quantity cannot be reverted.\n";

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
