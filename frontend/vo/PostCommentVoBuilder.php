<?php
namespace frontend\vo;

use Yii;

class PostCommentVoBuilder implements Builder {

    private $comment_id;
    private $creator_username;
    private $creator_first_name;
    private $creator_last_name;
    private $creator_id;
    private $stuff_id;
    private $message;
    private $created_at;
    private $creator_photo_path;
    
    public function build() {
        return new PostCommentVo($this);
    }
    
    public function getCommentId() {
        return $this->comment_id;
    }
    
    public function setCommentId($comment_id) {
        $this->comment_id = $comment_id;
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
    
}