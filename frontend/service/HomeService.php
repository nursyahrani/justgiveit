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
class HomeService {
    
    /**
     *
     * @var type frontend\dao\HomeDao
     */
    public $home_dao;
    
    private $profile_dao;
    
    function __construct() {
        $this->home_dao = new HomeDao();
        $this->profile_dao  = new ProfileDao();
    }
    
    public function getHomeInfoWithTag($current_user_id, $tag, HomeVoBuilder $builder) {
        $builder->setCurrentUserLocation(
                $this->home_dao->getCurrentUserLocationTextForSearch($current_user_id));
        $builder->setPostList($this->home_dao->getAllGiveStuffs($current_user_id, $tag));
        $builder->setMostPopularPost($this->home_dao->getMostPopularStuff());
        $builder->setHomeProfileView($this->profile_dao->getHomeProfileView($current_user_id));
        return $builder->build();
    }
    
    public function getHomeInfo($current_user_id, HomeVoBuilder $builder ) {
        $builder->setCurrentUserLocation(
                $this->home_dao->getCurrentUserLocationTextForSearch($current_user_id));
        $builder->setPostList($this->home_dao->getAllGiveStuffs($current_user_id, '','', $builder->getCurrentUserLocation()['id']));
        $builder->setMostPopularPost($this->home_dao->getMostPopularStuff());
        $builder->setHomeProfileView($this->profile_dao->getHomeProfileView($current_user_id));
        return $builder->build();
    }
    
    public function getMorePosts($current_user_id, $retrieved_post_ids,$query,$location ) {
        return $this->home_dao->getAllGiveStuffs($current_user_id, $retrieved_post_ids,$query,$location);
    }
    
    
    public function getMorePostsWithTag($current_user_id, $retrieved_post_ids, $tag ) {
        return $this->home_dao->getAllGiveStuffsWithTag($current_user_id, $retrieved_post_ids, $tag);
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
}