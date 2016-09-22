<?php

namespace frontend\vo;

use common\libraries\CommonLibrary;
use common\libraries\UserLibrary;
class BidVo implements Vo {
    private $bid_id;
    private $creator_username;
    private $creator_first_name;
    private $creator_last_name;
    private $creator_photo_path;
    private $creator_id;
    private $chosen_bid_reply;
    private $stuff_id;
    private $quantity;
    private $message;
    private $created_at;
    private $total_replies;
    private $obtain;
    private $confirm;
    
    function __construct(BidVoBuilder $builder) {
        $this->creator_username = $builder->getCreatorUsername();
        $this->creator_first_name = $builder->getCreatorFirstName();
        $this->creator_last_name = $builder->getCreatorLastName();
        $this->creator_id = $builder->getCreatorId();
        $this->stuff_id = $builder->getStuffId();
        $this->message = $builder->getMessage();
        $this->quantity = $builder->getQuantity();
        $this->created_at = $builder->getCreatedAt();
        $this->creator_photo_path = $builder->getCreatorPhotoPath();
        $this->obtain = $builder->hasObtained();
        $this->bid_id = $builder->getBidId();
        $this->confirm = $builder->hasConfirmed();
        $this->chosen_bid_reply = $builder->getChosenBidReply();
        $this->total_replies = $builder->getTotalReplies();
    }

    public static function createBuilder() {
        return new PostVoBuilder();
    }

    public function getChosenBidReply() {
        return $this->chosen_bid_reply;
    }
    public function getCreatedAt() {
        return CommonLibrary::getTimeText($this->created_at);
    }
    
    public function getCreatorUserLink() {
        return UserLibrary::buildUserLink($this->creator_username);
    }

    public function getCreatorFullName() {
        return $this->creator_first_name . ' ' . $this->creator_last_name;
    }
    
    public function hasConfirmed(){
        return $this->confirm;
    }
    
    public function hasObtained() {
        return $this->obtain === '0';
    }
    
    public function getCreatorPhotoPath() {
        return UserLibrary::buildPhotoPath($this->creator_photo_path);
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

    public function getBidId() {
        return $this->bid_id;
    }
    
    public function getQuantity() {
        return $this->quantity;
    }
    
    public function getTotalReplies() {
        return $this->total_replies;
    }
    
    public function isOwner() {
        return UserLibrary::isOwner($this->creator_id);
    }
}
