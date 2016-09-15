<?php

namespace frontend\vo;

use common\libraries\UserLibrary;
use common\libraries\CommonLibrary; 
use common\libraries\PostLibrary;   
use Yii;

class PostVo implements Vo {
    
    private $post_id;
    
    private $title;
    
    private $description;
    
    private $image;
    
    private $post_creator_id;
    
    private $post_creator_username;
    
    private $post_creator_first_name;
    
    private $post_creator_last_name;
    
    private $total_bids;
    
    private $post_status;
    
    private $has_bid;
    
    private $post_creator_photo_path;
    
    private $created_at;
    
    private $tags;
    
    private $deadline;
    
    private $bid_list;
    
    private $total_favorites;
    
    private $suggested_post;
    
    private $has_favorited;
    
    private $quantity;
    
    private $delivery;
    
    private $meet_up;
    
    private $post_comments;
   
    private $total_comments;
    
    
    function __construct(PostVoBuilder $builder) {
        $this->post_id  =$builder->getPostId();
        $this->title = $builder->getTitle();
        $this->description = $builder->getDescription();
        $this->image = $builder->getImage();
        $this->total_comments = $builder->getTotalComments();
        $this->post_creator_id = $builder->getPostCreatorId();
        $this->post_creator_first_name = $builder->getPostCreatorFirstName();
        $this->post_creator_last_name = $builder->getPostCreatorLastName();
        $this->post_creator_username = $builder->getPostCreatorUsername();
        $this->post_creator_photo_path = $builder->getPostCreatorPhotoPath();
        $this->deadline = $builder->getDeadline();
        $this->suggested_post = $builder->getSuggestedPost();
        $this->total_bids = $builder->getTotalBids();
        $this->tags = $builder->getTags();
        $this->created_at = $builder->getCreatedAt();
        $this->bid_list = $builder->getBidList();
        $this->has_bid = $builder->hasBid();
        $this->total_favorites = $builder->getTotalFavorites();
        $this->has_favorited = $builder->hasFavorited();
        $this->quantity = $builder->getQuantity();
        $this->delivery = $builder->isDeliveryPrefered();
        $this->meet_up = $builder->isMeetupPrefered();
        $this->post_comments = $builder->getPostComments();
        $this->post_status = $builder->getPostStatus();
    }
    
    public function getDeadline() {
        return CommonLibrary::getTextFromTimeDifference($this->deadline);
    }
    
    public function getSuggestedPost() {
        return $this->suggested_post;
    }
    
    public function getPostTags() {
        return $this->tags;
    }
    
    public function getAssocArrayPostTags() {
        $result = array();
        foreach($this->tags as $tag) {
            $result[$tag] = $tag;
        }
        
        return $result;
    }
    
    public function getTitle() {
        return $this->title;
    }
    
    public function getImage($width, $height) {
        return CommonLibrary::buildImageLibrary($this->image, $width, $height);
    }
    
    public function getDescription() {
        return $this->description;
    }
    
    public function getPostCreatorUserLink() {
        return UserLibrary::buildUserLink($this->post_creator_username);
    }

    public function getPostCreatorFullName() {
        return $this->post_creator_first_name . ' ' . $this->post_creator_last_name;
    }
    
    public function getPostCreatorId() {
        return $this->post_creator_id;
    }
    
    public function getPostId() {
        return $this->post_id;
    }
    
    public function getPostCreatorPhotoPath() {
        return UserLibrary::buildPhotoPath($this->post_creator_photo_path);
    }
    
    public static function createBuilder() {
        return new PostVoBuilder();
    }
    
    public function getPostLink() {
        return PostLibrary::buildPostLink($this->post_id, $this->title);
    }
    
    public function getCreatedAt() {
        return CommonLibrary::getTimeText($this->created_at);
    }
    
    public function getBidList() {
        return $this->bid_list;
    }
    
    public function getTotalBids() {
        return $this->total_bids;
    }
    
    public function hasBid() {
        return $this->has_bid;
    }
    
    public function isOwner() {
        if(Yii::$app->user->isGuest) {
            return 0;
        } else {
           if($this->post_creator_id == Yii::$app->user->getId()) {
               
               return 1;
            }  else {
               return 0;
           }
        }
    }
    
    public function getQuantity() {
        return $this->quantity;
        
    }
    
    public function isDeliveryPrefered() {
        return $this->delivery;
    }
    
    public function isMeetupPrefered() {
        return $this->meet_up;
    }
    public function hasFavorited() {
        return $this->has_favorited;
    }
    
    public function getTotalFavorites() {
        return $this->total_favorites;
    }
    
    public function getPostComments() {
        return $this->post_comments;
    }
    
    public function getTotalComments() {
        return $this->total_comments;
    }
    
    public function getPostStatus() {
        return $this->post_status;
    }
}