<?php

namespace frontend\vo;

use frontend\vo\BidReplyVoBuilder;
use common\libraries\CommonLibrary;
use common\libraries\UserLibrary;

class BidReplyVo implements Vo {
    private $bid_reply_id;
    private $bid_id;
    private $creator_username;
    private $creator_first_name;
    private $creator_last_name;
    private $creator_photo_path;
    private $creator_id;
    private $message;
    private $created_at;
    
    function __construct(BidReplyVoBuilder $builder) {
        $this->creator_username = $builder->getCreatorUsername();
        $this->creator_first_name = $builder->getCreatorFirstName();
        $this->creator_last_name = $builder->getCreatorLastName();
        $this->creator_id = $builder->getCreatorId();
        $this->message = $builder->getMessage();
        $this->created_at = $builder->getCreatedAt();
        $this->creator_photo_path = $builder->getCreatorPhotoPath();
        $this->bid_id = $builder->getBidId();
        $this->bid_reply_id = $builder->getBidReplyId();
    }

    public static function createBuilder() {
        return new BidReplyVoBuilder();
    }
    
    public function getBidReplyId() {
        return $this->bid_reply_id;
    }
    
    public function getCreatedAt() {
        return CommonLibrary::getTimeText($this->created_at);
    }
    
    public function getCreatedAtTimestamp() {
        return $this->created_at;
    }
    
    public function getCreatorUserLink() {
        return UserLibrary::buildUserLink($this->creator_username);
    }

    public function getCreatorFullName() {
        return $this->creator_first_name . ' ' . $this->creator_last_name;
    }
    
    public function getCreatorPhotoPath() {
        return UserLibrary::buildPhotoPath($this->creator_photo_path);
    }


    public function getCreatorId() {
        return $this->creator_id;
    }


    public function getMessage() {
        return $this->message;
    }

    public function getBidId() {
        return $this->bid_id;
    }

}
