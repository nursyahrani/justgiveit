<?php

namespace frontend\service;

use frontend\dao\HomeDao;
class ServiceFactory {


    const HOME_SERVICE = "home_service";

    public function getService($serviceType ){

        if($serviceType === self::HOME_SERVICE){
            return new HomeService(new HomeDao() );
        }
        return null;
    }
}