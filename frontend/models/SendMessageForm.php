<?php

namespace frontend\models;

use common\models\Message;
use common\models\Post;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
/**
 * ContactForm is the model behind the contact form.
 */
class SendMessageForm extends Model
{
    public $sender_id;
    public $receiver_id;
    public $message;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['sender_id', 'receiver_id', 'message'], 'required'],
            [['receiver_id', 'sender_id'], 'integer'],
            [ 'message', 'string'],
        ];
    }

    public function send(){
        $image = UploadedFile::getInstance($this, 'imageFile');

        $message= new Message();
        $message->sender_id = $this->sender_id;
        $message->receiver_id = $this->receiver_id;
        $message->message = $this->message;

        if($message->save()){
            return true;
        }
    }

}
