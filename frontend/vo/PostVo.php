<?php

namespace frontend\vo;

use common\libraries\UserLibrary;
use common\libraries\CommonLibrary; 
use common\libraries\PostLibrary;   

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
    
    private $post_creator_photo_path;
    
    private $created_at;
    
    private $tags;
    
    private $deadline;
    
    private $bid_list;
    
    function __construct(PostVoBuilder $builder) {
        $this->post_id  =$builder->getPostId();
        $this->title = $builder->getTitle();
        $this->description = $builder->getDescription();
        $this->image = $builder->getImage();
        $this->post_creator_id = $builder->getPostCreatorId();
        $this->post_creator_first_name = $builder->getPostCreatorFirstName();
        $this->post_creator_last_name = $builder->getPostCreatorLastName();
        $this->post_creator_username = $builder->getPostCreatorUsername();
        $this->post_creator_photo_path = $builder->getPostCreatorPhotoPath();
        $this->deadline = $builder->getDeadline();
        $this->total_bids = $builder->getTotalBids();
        $this->tags = $builder->getTags();
        $this->created_at = $builder->getCreatedAt();
        $this->bid_list = $builder->getBidList();
        
    }
    
    public function getDeadline() {
        return CommonLibrary::getTextFromTimeDifference($this->deadline);
    }
    
    public function getPostTags() {
        return $this->tags;
    }
    
    public function getTitle() {
        return $this->title;
    }
    
    public function getImage() {
        return CommonLibrary::buildImageLibrary($this->image);
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
}