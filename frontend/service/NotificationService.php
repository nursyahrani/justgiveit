<?php
namespace frontend\service;

use frontend\vo\PostVoBuilder;
use frontend\dao\NotificationDao;
use common\libraries\UserLibrary;

class NotificationService {
    
    /**
     *
     * @var type frontend\dao\HomeDao
     */
    public $notification_dao;
    
    
    function __construct() {
        $this->notification_dao = new NotificationDao();
    }
    
    function countNewNotification($user_id) {
        return $this->notification_dao->getCountNotification($user_id);
    }
    
    function getNotification($user_id) {
        return $this->notification_dao->getNotificationList($user_id);
    }
    
    
    
}