<?php
namespace frontend\controllers;

use Yii;
use frontend\widgets\NotificationItem;
use yii\web\Controller;
use frontend\service\ServiceFactory;
use frontend\widgets\PostComment;
use frontend\models\NotificationCommentCommentForm;
/**
 * Site controller
 */
class NotificationController extends Controller
{
    
    private $service_factory;
    
    private $notification_service;
    
    public function init() {
        $this->service_factory = new ServiceFactory();
        $this->notification_service = $this->service_factory->getService(ServiceFactory::NOTIFICATION_SERVICE);
    }
    
    public function actionCountNewNotification() {
        $data = array();
        if(Yii::$app->user->isGuest) {
            $data['status'] = 0;
            return json_encode($data);
        }
        
        $count = $this->notification_service->countNewNotification(Yii::$app->user->getId());
        $data['count'] = $count;
        $data['status'] = 1;
        return json_encode($data);
    }
    
    public function actionUpdateLastSeen() {
        $data = array();
        if(Yii::$app->user->isGuest) {
            $data['status'] = 0;
            return json_encode($data);
        }
        
        
    }
    
    public function actionRetrieveNotification() {
        $data = array();
        if(Yii::$app->user->isGuest) {
            $data['status'] = 0;
            return json_encode($data);
        }
        
        $notifications = $this->notification_service->getNotification(Yii::$app->user->getId());
        $views = '';    
        foreach($notifications as $notification) {
            $views .= NotificationItem::widget(['id' => 'notification-item-' . $notification->getNotificationId(), 'notification' => $notification]);
        }
        
        $data['status'] = 1;
        $data['views'] = $views;
        return json_encode($data);
    }
}
