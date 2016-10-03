<?php
namespace frontend\models;
use common\models\NotificationReceiver;
use yii\base\Model;
/**
 * Signup form
 */
class SetUnreadNotificationForm extends Model
{
    public $notification_id;
    
    public $user_id;
    /*
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['notification_id', 'integer'],
            ['user_id', 'integer'],
            ['notification_id', 'required'],
            ['user_id', 'required']
        ];
    }
    
    public function setUnread() {
        $notification_receiver = NotificationReceiver::find()
                ->where(['notification_id' => $this->notification_id,
                         'receiver_id' => $this->user_id])->one();
        if(!$notification_receiver) {
            return false;
        }
        $notification_receiver->is_read = 1;
        return $notification_receiver->update();
    }
}
