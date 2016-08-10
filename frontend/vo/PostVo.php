<?php

namespace frontend\vo;

use common\libraries\UserLibrary;
use common\libraries\CommonLibrary;
class PostVo implements Vo {
    
    private $post_id;
    
    private $title;
    
    private $description;
    
    private $image;
    
    private $post_creator_id;
    
    private $post_creator_username;
    
    private $post_creator_first_name;
    
    private $post_creator_last_name;
    
    private $post_creator_photo_path;
    
    private $tags;
    
    private $deadline;
    
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
        $this->tags = $builder->getTags();
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
    
}