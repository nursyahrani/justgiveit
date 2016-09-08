<?php

use yii\db\Migration;

class m160908_040000_validation_code_table extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE user_email_authentication add validation_code varchar(255) null");
    }

    public function down()
    {
        echo "m160908_040000_validation_code_table cannot be reverted.\n";

        return false;
    }

}
