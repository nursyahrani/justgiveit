<?php

use yii\db\Migration;

class m160807_171739_update_table_to_new_system extends Migration
{
    public function up()
    {
        $this->execute(""
                . "DROP TABLE give_stuff_to_user;"
                . "DROP TABLE interested;"
                );
        $this->execute("CREATE TABLE tag("
                . "tag_name varchar(255) not null primary key,"
                . "tag_description text null,"
                . "created_at int not null,"
                . "updated_at int not null);");
        
        $this->execute("CREATE TABLE post_tag("
                
                . "post_id int not null,"
                . "tag_name varchar(255) not null,"
                . "created_at int not null,"
                . "updated_at int not null,"
                . "primary key(post_id, tag_name),"
                . "foreign key(post_id) references  post(stuff_id),"
                . "foreign key(tag_name) references tag(tag_name)  "
                . ");");

    }

    public function down()
    {
        echo "m160807_171739_update_table_to_new_system cannot be reverted.\n";

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
