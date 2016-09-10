<?php

use yii\db\Migration;

class m160910_100714_starred_tag_table extends Migration
{
    public function up()
    {
        $this->execute("CREATE TABLE starred_tag(user_id int not null, tag_id int not null, created_at int not null, updated_at int not null,
                primary key(user_id, tag_id), foreign key(user_id) references user(id), foreign key(tag_id) references tag(tag_id))");
        
    }

    public function down()
    {
        echo "m160910_100714_starred_tag_table cannot be reverted.\n";

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
