<?php

namespace frontend\service;

use frontend\dao\HomeDao;
use frontend\dao\PostDao;
use frontend\dao\ProfileDao;
class ServiceFactory {


    const HOME_SERVICE = "home_service";

    const POST_SERVICE = "post_service";

    const PROFILE_SERVICE = "profile_service";
    
    
    const BID_SERVICE = "bid_service";
    public function getService($serviceType ){

        if($serviceType === self::HOME_SERVICE){
            return new HomeService(new HomeDao() );
        } else if ($serviceType === self::POST_SERVICE) {
            return new PostService(new PostDao());
        } else if($serviceType === self::PROFILE_SERVICE) {
            return new ProfileService(new ProfileDao());
        } else if($serviceType === self::BID_SERVICE) {
            return new BidService();
        }
        return null;
    }
}