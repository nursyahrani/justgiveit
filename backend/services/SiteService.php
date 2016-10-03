<?php
namespace backend\services;
use backend\vos\SiteVoBuilder;
use backend\daos\SiteDao;
class SiteService {
    
    private $site_dao;
    
    public function __construct() {
        $this->site_dao = new SiteDao();
    }
    
    public function getHomeInfo() {
        $builder = new SiteVoBuilder();
        
        $builder->setPopularTags($this->site_dao->getMostPopularTags());
        $builder->setItemsByCountry($this->site_dao->getItemsByCountry());
        $builder->setItemsByDay($this->site_dao->getItemsByDay());
        $builder->setRegisteredUserByCountry($this->site_dao->getRegisteredUserByCountry());
        return $builder->build();
    }
}