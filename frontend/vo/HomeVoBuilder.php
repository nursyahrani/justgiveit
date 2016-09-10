<?php
namespace frontend\vo;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class HomeVoBuilder implements Builder {
    
    
    private $count_new_notification;
    
    private $post_list;
    
    private $most_popular_post;
    
    private $home_profile_view;
    
    private $most_popular_tag;
    
    private $starred_tag_list;
    
    private $current_user_location;
    
    public function build() {
        return new HomeVo($this);
    }
    
    public function getHomeProfileView() {
        return $this->home_profile_view;
    
        
    }
    
    
    
    public function getStarredTagList() {
        return $this->starred_tag_list;
    }
    
    public function getMostPopularTag() {
        return $this->most_popular_tag;
    }
    
    public function  setStarredTagList($starred_tag_list) {
        $this->starred_tag_list = $starred_tag_list;
    }
    
    public function setMostPopularTag($most_popular_tag) {
        $this->most_popular_tag = $most_popular_tag;
    }
    
    public function getCountNewNotification() {
        return $this->count_new_notification;
    }
    
    public function setCountNewNotification($count_new_notification) {
        $this->count_new_notification = $count_new_notification;
    }
    
    public function setHomeProfileView($home_profile_view) {
        $this->home_profile_view  = $home_profile_view;
    }
    public function getMostPopularPost() {
        return $this->most_popular_post;
    }
    
    public function setMostPopularPost($most_popular_post) {
        $this->most_popular_post = $most_popular_post;
    }
    
    function getPostList() {
        return $this->post_list;
    }


    function setPostList($post_list) {
        $this->post_list = $post_list;
    }

    public function getCurrentUserLocation() {
        return $this->current_user_location;
    }
    
    public function setCurrentUserLocation($current_user_location) {
        $this->current_user_location = $current_user_location;
    }
    
}