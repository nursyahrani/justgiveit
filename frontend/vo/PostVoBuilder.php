<?php
namespace frontend\vo;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use frontend\vo\PostVo;
class PostVoBuilder implements Builder {
    
    private $post_id;
    
    private $title;
    
    private $description;
    
    private $image;
    
    private $post_creator_id;
    
    private $deadline;
    
    private $post_creator_username;
    
    private $post_creator_first_name;
    
    private $post_creator_last_name;
    
    private $post_creator_photo_path;
    
    private $tags;
    
    public function build() {
        return new PostVo($this);
    }
    
    public function getPostId() {
        return $this->post_id;
    }
    
    public function getDeadline() {
        return $this->deadline;
    }
    
    public function setDeadline($deadline) {
        $this->deadline = $deadline;
    }
    function getTitle() {
        return $this->title;
    }

    function getDescription() {
        return $this->description;
    }

    function getImage() {
        return $this->image;
    }

    function getPostCreatorId() {
        return $this->post_creator_id;
    }
    
    function getTags() {
        return $this->tags;
    }

    function getPostCreatorUsername() {
        return $this->post_creator_username;
    }

    function getPostCreatorFirstName() {
        return $this->post_creator_first_name;
    }

    function getPostCreatorLastName() {
        return $this->post_creator_last_name;
    }
    
    
    function getPostCreatorPhotoPath() {
        return $this->post_creator_photo_path;
    }
    
    function setPostCreatorPhotoPath($post_creator_photo_path) {
        $this->post_creator_photo_path = $post_creator_photo_path;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setImage($image) {
        $this->image = $image;
    }

    function setPostCreatorId($post_creator_id) {
        $this->post_creator_id = $post_creator_id;
    }

    function setPostCreatorUsername($post_creator_username) {
        $this->post_creator_username = $post_creator_username;
    }

    function setPostCreatorFirstName($post_creator_first_name) {
        $this->post_creator_first_name = $post_creator_first_name;
    }

    function setPostCreatorLastName($post_creator_last_name) {
        $this->post_creator_last_name = $post_creator_last_name;
    }
    
    function setPostId($post_id) {
        $this->post_id = $post_id;
    }
    
    function setTags($tags) {
        $this->tags = $tags;
    }

    
}