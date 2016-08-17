<?php

namespace frontend\service;

use frontend\dao\HomeDao;
use frontend\dao\PostDao;
class ServiceFactory {


    const HOME_SERVICE = "home_service";

    const POST_SERVICE = "post_service";

    public function getService($serviceType ){

        if($serviceType === self::HOME_SERVICE){
            return new HomeService(new HomeDao() );
        } else if ($serviceType === self::POST_SERVICE) {
            return new PostService(new PostDao());
        }
        return null;
    }
}