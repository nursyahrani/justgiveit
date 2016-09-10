<?php

use yii\db\Migration;

class m160909_124554_new_notification_for_reply_proposal extends Migration
{
    public function up()
    {
        $notification_type = common\models\NotificationType::find()->where(['notification_type_name' => 'bid'])->one();
        $notification_type->url_template = "post/%1$%/%2$%#bid-%3$%";
        $notification_type->update();

    }

    public function down()
    {
        echo "m160909_124554_new_notification_for_reply_proposal cannot be reverted.\n";

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
