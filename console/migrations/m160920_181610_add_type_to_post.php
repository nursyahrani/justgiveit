<?php

use yii\db\Migration;
use common\models\Post;

class m160920_181610_add_type_to_post extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE post add type int(11) not null default " . Post::GIVE_STUFF);
    }

    public function down()
    {
        echo "m160920_181610_add_type_to_post cannot be reverted.\n";

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
