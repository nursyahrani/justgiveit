<?php
namespace frontend\service;

use frontend\dao\ProfileDao;

class ProfileService {
    
    /**
     *
     * @var type frontend\dao\HomeDao
     */
    public $profile_dao;
    
    function __construct(ProfileDao $profile_dao) {
        $this->profile_dao = $profile_dao;
    }
    
    function getProfileAndStuffList($current_user_id,$username, $limit) {
        $builder = new \frontend\vo\ProfileVoBuilder();
        $builder = $this->profile_dao->getProfileInfo( $username, $builder);
        $builder->setGiveList($this->profile_dao->getStuffList($current_user_id,$username, $limit));
        return $builder->build();
    }
    
    function getProfileAndBidList($current_user_id, $username, $limit) {
        $builder = new \frontend\vo\ProfileVoBuilder();
        $builder = $this->profile_dao->getProfileInfo($username, $builder);
        $builder->setBidList($this->profile_dao->getBidList($username), $limit);
        return $builder->build();
        
    }
    
    
}