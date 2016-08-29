<?php
namespace frontend\vo;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class HomeVoBuilder implements Builder {
    
    private $post_list;
    
    private $most_popular_post;
    
    private $home_profile_view;
    
    private $current_user_location;
    
    public function build() {
        return new HomeVo($this);
    }
    
    public function getHomeProfileView() {
        return $this->home_profile_view;
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