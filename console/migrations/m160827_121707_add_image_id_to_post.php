<?php

use yii\db\Migration;

class m160827_121707_add_image_id_to_post extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE post add image_id int not null");
        
        if(count(\common\models\Image::find()->all()) !== 0) {
            $this->execute("UPDATE post set post.image_id = 1");
        }
        $this->execute("ALTER TABLE post add FOREIGN KEY(image_id) references image(image_id);");
        $this->execute("UPDATE post, image SET post.image_id = image.image_id "
                . "where image.user_id = post.poster_id and post.photo_path = image.image_path");
    }

    public function down()
    {
        echo "m160827_121707_add_image_id_to_post cannot be reverted.\n";

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
