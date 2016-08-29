<?php

namespace frontend\models;

use yii\base\Model;
use common\models\BidReply;
use common\models\Bid;
use common\libraries\UserLibrary;
use common\models\Post;
/**
 * ContactForm is the model behind the contact form.
 */
class BidReplyForm extends Model
{
    public $user_id;
    public $bid_id;
    public $message;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['user_id', 'bid_id', 'message'], 'required'],
            ['message', 'string'],
            [['user_id', 'bid_id'], 'integer']
        ];
    }

    public function create(){
        if(!$this->validate()) {
            return false;
        }
        
        if(!$this->isEligible())  {
            return false;
        }
        
        $bid_reply = new BidReply;
        $bid_reply->bid_id = $this->bid_id;
        $bid_reply->user_id = $this->user_id;
        $bid_reply->message = $this->message;
        if(!$bid_reply->save()) {
            return false;
        }
        return $bid_reply->bid_reply_id;
    }
    
    //only the post owner and the bidder can speak
    
    private function isEligible() {
        $bid = Bid::find()->where(['bid_id' => $this->bid_id])->one();
       
        if(UserLibrary::isOwner($bid['proposer_id'])) {
            return true;
        }
        
        $stuff = Post::find()->where(['stuff_id' => $bid['stuff_id']])->one();
        
        if(UserLibrary::isOwner($stuff['poster_id'])) {
            return true;
        }
    
        return false;
    }
}
