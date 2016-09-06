<?php

use yii\db\Migration;

class m160905_193223_post_comment extends Migration
{
    public function up()
    {
        $this->execute("create table post_comment(comment_id int not null primary key, "
                . "post_id int not null, "
                . "user_id int not null, "
                . "message text not null,"
                . "created_at int not null,"
                . "updated_at int not null,"
                . "foreign key (user_id) references user(id),"
                . "foreign key(post_id) references post(stuff_id) )");
        
    }

    public function down()
    {
        echo "m160905_193223_post_comment cannot be reverted.\n";

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
