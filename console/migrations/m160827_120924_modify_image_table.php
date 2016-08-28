<?php

use yii\db\Migration;

class m160827_120924_modify_image_table extends Migration
{
    public function up()
    {
        $this->execute("DROP TABLE image;");
        
        $this->execute("CREATE TABLE image("
                . "image_id int not null primary key auto_increment,"
                . "user_id int not null,"
                . "image_path varchar(255) not null unique,"
                . "created_at int not null,"
                . "updated_at int not null,"
                . "foreign key (user_id) references user(id)"
                . ");");
    }

    public function down()
    {
        echo "m160827_120924_modify_image_table cannot be reverted.\n";

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
