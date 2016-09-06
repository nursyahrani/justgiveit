<?php
namespace frontend\vo;

use Yii;

class BidVoBuilder implements Builder {

    private  $bid_id;
    private $creator_username;
    private $creator_first_name;
    private $creator_last_name;
    private $creator_id;
    private $quantity;
    private $total_replies;
    private $stuff_id;
    private $message;
    private $created_at;
    private $creator_photo_path;
    private $obtain;
    private $confirm;
    private $chosen_bid_reply;
    
    public function build() {
        return new BidVo($this);
    }
    
    public function getChosenBidReply() {
        return $this->chosen_bid_reply;
    }
    
    public function getQuantity() {
        return $this->quantity;
    }
    
    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }
    
    public function setChosenBidReply($chosen_bid_reply) {
        $this->chosen_bid_reply = $chosen_bid_reply;
    }
    
    public function hasObtained() {
        return $this->obtain;
    }
    
    public function hasConfirmed() {
        return $this->confirm;
    }
    
    public function setHasObtained($obtain) {
        $this->obtain = $obtain;
    }
    
    public function setHasConfimed($confirm) {
        $this->confirm = $confirm;
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

    public function getStuffId() {
        return $this->stuff_id;
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

    public function setStuffId($stuff_id) {
        $this->stuff_id = $stuff_id;
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
    
    public function setTotalReplies($total_replies) {
        $this->total_replies = $total_replies;  
    }
    
    public function getTotalReplies() {
        return $this->total_replies;
    }
}