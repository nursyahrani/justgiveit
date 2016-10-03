<?php
namespace frontend\models;
use yii\base\Model;
use common\models\Post;
use common\libraries\CommonLibrary;
use common\models\NotificationExtraValue;
use common\models\NotificationActor;
use common\models\Notification;
use common\models\NotificationReceiver;
/**
 * Signup form
 */
class NotificationPostThanksForm extends Model
{
    //url _key value
    public $post_id;
    
    //actor - current user
    public $new_actor_id;
    
    //receiver - post-author
    private $post;
    
    private $notification_dao;
    
    const   NOTIFICATION_TYPE_NAME = "post";
    
    const POST_THANKS = "post_thanks";
    
    public function __construct($config = array()) {
        $this->notification_dao = new \frontend\dao\NotificationDao();
        parent::__construct($config);
    }
    /*
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['post_id' , 'integer'],
            ['new_actor_id', 'integer'],
            [['post_id', 'new_actor_id'], 'required']
        ];
    }
    
    public function create() {
        
        $this->post = Post::find()
                ->where(['stuff_id' => $this->post_id])->one();
        $notification = $this->getNotification();
        if(!$notification) {
            $notification = new Notification();
            $notification->notification_type_name = self::NOTIFICATION_TYPE_NAME;
            $notification->notification_verb_name = self::POST_THANKS;
            $notification->url_key_value = $this->post_id;
            if(!$notification->save()) {
                return false;
            }
        }
        $notification_extra_value = $this->getNotificationExtraValue();
        if(!$notification_extra_value) {
            $notification_extra_value = new NotificationExtraValue;
            $notification_extra_value->notification_type_name = self::NOTIFICATION_TYPE_NAME;
            $notification_extra_value->url_key_value = $this->post_id;
            $notification_extra_value->extra_value = CommonLibrary::cutText($this->post['title']);
            if(!$notification_extra_value->save()) {
                return false;
            }
        }
        
        $notification_receiver = $this->getNotificationReceiver($notification->notification_id);
        if(!$notification_receiver) {
            $notification_receiver = new NotificationReceiver();
            $notification_receiver->notification_id = $notification->notification_id;
            
            $notification_receiver->receiver_id = $this->post['poster_id'];
            if(!$notification_receiver->save()) {
                return false;
            }
        } else {
            $notification_receiver->is_read = 0;
            $notification_receiver->update();
        }
         
        $notification_actor = $this->getNotificationActor($notification->notification_id);
        
        if(!$notification_actor) {
            $notification_actor = new NotificationActor();
            $notification_actor->notification_id = $notification->notification_id;
            $notification_actor->actor_id = $this->new_actor_id;
            if(!$notification_actor->save()) {
                return false;
            }
         } else {
             $notification_actor->updated_at = time();
             $notification_actor->update();
         }
         
        return true; 
    }
    
    public function delete($verb) {
        $notification = $this->getNotification($verb);
        if(!$notification) {
            //notification must be there during creation
            return false;
        }
        
        $notification_actor = $this->getNotificationActor($notification->notification_id);
        if(!$notification_actor) {
            return false;
        }
        
        $this->deleteNotificationActor($notification->notification_id);
        
        
    }
    
    private function getNotification() {
       return Notification::find()->where(['notification_type_name' => self::NOTIFICATION_TYPE_NAME, 'notification_verb_name' => self::POST_THANKS,
                                    'url_key_value' => $this->post_id])->one();
    }
    
    private function getNotificationReceiver($notification_id) {
        return NotificationReceiver::find()->where(['notification_id' => $notification_id])->one();
    }
    
    private function getNotificationActor($notification_id) {
        return NotificationActor::find()->where(['notification_id' => $notification_id, 'actor_id' => $this->new_actor_id])->one();
    }
    
    private function deleteNotificationActor($notification_id) {
        NotificationActor::deleteAll(['notification_id' => $notification_id, 'actor_id' => $this->new_actor_id]);
    }
    
    private function getNotificationExtraValue() {
        return NotificationExtraValue::find()->where(['notification_type_name' => self::NOTIFICATION_TYPE_NAME, 'url_key_value' => $this->post_id])->one();
    }
}
