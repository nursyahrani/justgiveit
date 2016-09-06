<?php

use yii\db\Migration;

class m160903_114033_alter_post_and_pick_up_location extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE pick_up_location add created_at int not null; alter table pick_up_location add updated_at int not null;");
        $this->execute("ALTER TABLE post add quantity int not null; ALTER TABLE post add delivery boolean not null; ALTER TABLE post add meet_up boolean not null;");
        $this->execute("ALTER TABLE post add pick_up_location_id int not null; ALTER TABLE post add Foreign key (pick_up_location_id) references pick_up_location(pick_up_location_id);");
    }

    public function down()
    {
        echo "m160903_114033_alter_post_and_pick_up_location cannot be reverted.\n";

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
