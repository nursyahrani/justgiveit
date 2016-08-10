<?php
namespace frontend\service;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use frontend\dao\HomeDao;
use frontend\vo\HomeVoBuilder;

class HomeService {
    
    /**
     *
     * @var type frontend\dao\HomeDao
     */
    public $home_dao;
    
    function __construct() {
        $this->home_dao = new HomeDao();
    }
    
    public function getHomeInfoWithTag($current_user_id, $tag, HomeVoBuilder $builder) {
        $builder = $this->home_dao->getAllGiveStuffs($builder, $tag);
        return $builder->build();
    }
    
    public function getHomeInfo($current_user_id,  HomeVoBuilder $builder ) {
        
        $builder = $this->home_dao->getAllGiveStuffs($builder);
        
        return $builder->build();
    }
    
    /**
     * JSON response
     * @param type $query
     */
    public function searchIssue($query) {
        return $this->home_dao->searchIssue($query);
    }
}