<?php
namespace frontend\vo;

use Yii;

class BidReplyVoBuilder implements Builder {

    private  $bid_id;
    private $bid_reply_id;
    private $creator_username;
    private $creator_first_name;
    private $creator_last_name;
    private $creator_id;
    private $message;
    private $created_at;
    private $creator_photo_path;
    
    public function build() {
        return new BidReplyVo($this);
    }
    
    public function getBidReplyId() {
        return $this->bid_reply_id;
    }
    
    public function setBidReplyId($bid_reply_id) {
        $this->bid_reply_id = $bid_reply_id;
    }
    
    public function getCreatorUsername() {
        return $this->creator_username;
    }

    public function getCreatorFirstName() {
        return $this->creator_first_name;
    }

    public function getCreatorLastName() {
        return $this->creator_last_name;
    }

    public function getCreatorId() {
        return $this->creator_id;
    }

    public function getMessage() {
        return $this->message;
    }
    
    public function getCreatedAt() {
        return $this->created_at;
    }
    
    public function setCreatorUsername($creator_username) {
        $this->creator_username = $creator_username;
    }

    public function setCreatorFirstName($creator_first_name) {
        $this->creator_first_name = $creator_first_name;
    }

    public function setCreatorLastName($creator_last_name) {
        $this->creator_last_name = $creator_last_name;
    }

    public function setCreatorId($creator_id) {
        $this->creator_id = $creator_id;
    }

    public function setMessage($message) {
        $this->message = $message;
    }
    
    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }

    public function getCreatorPhotoPath() {
        return $this->creator_photo_path;
    }
    
    public function setCreatorPhotoPath($creator_photo_path) {
        $this->creator_photo_path = $creator_photo_path;
    }
    
    public function getBidId() {
        return $this->bid_id;
        
    }
    
    public function setBidId($bid_id) {
        $this->bid_id = $bid_id;
    }
    
    public function applyTemplate() {
        $this->bid_id = 0;
        if(!Yii::$app->user->isGuest) {
         
            $this->creator_first_name = Yii::$app->user->identity->first_name;
            $this->creator_last_name = Yii::$app->user->identity->last_name;
            $this->creator_username = Yii::$app->user->identity->username;
            $this->creator_photo_path = Yii::$app->user->identity->profile_pic;   
        }
        $this->created_at = time();
        $this->message = "{message}";
    }
    
}