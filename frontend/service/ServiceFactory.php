<?php

namespace frontend\service;

use frontend\dao\HomeDao;
use frontend\dao\PostDao;
use frontend\dao\ProfileDao;
class ServiceFactory {


    const HOME_SERVICE = "home_service";

    const POST_SERVICE = "post_service";

    const PROFILE_SERVICE = "profile_service";
    
    const POST_COMMENT_SERVICE = "post_comment_service";
    
    const BID_SERVICE = "bid_service";
    
    const NOTIFICATION_SERVICE = "notification_service";
    
    const TAG_SERVICE = "tag_service";
    
    public function getService($serviceType ){

        if($serviceType === self::HOME_SERVICE){
            return new HomeService(new HomeDao() );
        } else if ($serviceType === self::POST_SERVICE) {
            return new PostService(new PostDao());
        } else if($serviceType === self::PROFILE_SERVICE) {
            return new ProfileService(new ProfileDao());
        } else if($serviceType === self::BID_SERVICE) {
            return new BidService();
        } else if($serviceType === self::POST_COMMENT_SERVICE) {
            return new PostCommentService();
        } else if($serviceType === self::NOTIFICATION_SERVICE) {
            return new NotificationService();
        } else if($serviceType === self::TAG_SERVICE) {
            return new TagService();
        }
        return null;
    }
}