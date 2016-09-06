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
    
    private $total_bids;
    
    private $total_favorites;
    
    private $has_favorited;
    
    private $suggested_post;
    
    private $description;
    
    private $post_comments;
    
    private $total_comments;
    private $image;
    
    private $post_creator_id;
    
    private $deadline;
    
    private $post_creator_username;
    
    private $post_creator_first_name;
    
    private $post_creator_last_name;
    
    private $post_creator_photo_path;
    
    private $tags;
    
    private $bid_list;
    
    private $created_at;
    
    private $has_bid;
    
    private $meet_up;
    
    private $delivery;
    
    private $quantity;
    
    
    public function build() {
        return new PostVo($this);
    }
    
    public function hasBid() {
        return $this->has_bid;
    }
    
    public function setHasBid($has_bid) {
        $this->has_bid = $has_bid;
    }
    
    public function setHasFavorited($has_favorited) {
        $this->has_favorited = $has_favorited;
    }
    
    public function hasFavorited() {
        return $this->has_favorited;
    }
    
    public function setTotalFavorites($total_favorites) {
        $this->total_favorites =  $total_favorites;
    }
    
    public function getTotalFavorites() {
        return $this->total_favorites;
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

    function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }
    
    public function getCreatedAt() {
        return $this->created_at;
    }
    
    public function setBidList($bid_list) {
        $this->bid_list = $bid_list;
    }
    
    public function getBidList() {
        return $this->bid_list;
    }
    
    
    public function setTotalBids($total_bids) {
        $this->total_bids = $total_bids;
    }
    
    public function getTotalBids() {
        return $this->total_bids;
    }
    
    public function getSuggestedPost() {
        return $this->suggested_post;
    }
    
    public function setSuggestedPost($suggested_post) {
        $this->suggested_post = $suggested_post;
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
    
    public function setQuantity($quantity) {
        $this->quantity =$quantity;
    }
    
    public function setDelivery($delivery) {
        $this->delivery = $delivery;
    }
    
    public function setMeetup($meet_up) {
        $this->meet_up = $meet_up;
    }
    
    public function getPostComments() {
        return $this->post_comments;
    }
    
    public function setPostComments($post_comments) {
        $this->post_comments = $post_comments;
    }
    
    
    public function getTotalComments() {
        return $this->total_comments;
    }
    
    public function setTotalComments($total_comments) {
        $this->total_comments = $total_comments;
    }
}