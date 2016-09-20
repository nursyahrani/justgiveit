<?php
namespace frontend\service;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use frontend\dao\HomeDao;
use frontend\vo\HomeVoBuilder;
use frontend\dao\ProfileDao;
use frontend\dao\NotificationDao;
use frontend\dao\TagDao;
class HomeService {
    
    public $home_dao;
    
    private $profile_dao;

    private $notification_dao;
    
    private $tag_dao;
    
    public function __construct() {
        $this->home_dao = new HomeDao();
        $this->profile_dao  = new ProfileDao();
        $this->notification_dao = new NotificationDao();
        $this->tag_dao = new TagDao;
    }
    
    
    public function getHomeInfo($current_user_id, HomeVoBuilder $builder , $init_tag = null) {
        $builder->setPostList($this->home_dao->getAllGiveStuffs($current_user_id, '','', $builder->getCurrentUserLocation()['id'], $init_tag));
        $builder->setHomeProfileView($this->profile_dao->getHomeProfileView($current_user_id));
        $tag = array();
        if($init_tag) {
            $tag[] = $this->tag_dao->getTag($init_tag, $current_user_id, null, true);
        }
        $popular_tag = $this->tag_dao->getMostPopularTag($current_user_id, $init_tag);
        $tag = array_merge($tag, $popular_tag);
        $builder->setMostPopularTag($tag);
        $builder->setStarredTagList($this->tag_dao->getStarredTag($current_user_id,$init_tag));
        return $builder->build();
    }
    
    /**
     * 
     * @param type $current_user_id
     * @param type $retrieved_post_ids
     * @param type $query
     * @param type $location
     * @param type $tags
     * @return type
     */
    public function getPosts($current_user_id, $retrieved_post_ids, $query, $location, $tags ) {
        return $this->home_dao->getAllGiveStuffs($current_user_id, $retrieved_post_ids, $query, $location, $tags);
    }
    
    /**
     * JSON response
     * @param type $query
     */
    public function searchIssue($query) {
        return $this->home_dao->searchIssue($query);
    }
    
    public function searchCountryCity($pre, $post = null) {
        return $this->home_dao->searchCountryCity($pre, $post);
    }
    
    public function searchCity($pre, $post = null) {
        return $this->home_dao->searchCity($pre, $post);
    }
}