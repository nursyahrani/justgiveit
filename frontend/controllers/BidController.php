<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\widgets\BidReply;
use frontend\service\ServiceFactory;
use frontend\models\BidReplyForm;
/**
 * Site controller
 */
class BidController extends Controller
{
    
    private $service_factory;
    
    private $bid_service;
    
    public function init() {
        $this->service_factory = new ServiceFactory();
        $this->bid_service = $this->service_factory->getService(ServiceFactory::BID_SERVICE);
    }

    public function actionReply() {
        $data = array();
        if(Yii::$app->user->isGuest || !isset($_POST['bid_id']) || !isset($_POST['message'])) {
            $data['status'] = 0;
            return json_encode($data);
        }
        
        $model = new BidReplyForm();
        $model->user_id = Yii::$app->user->getId();
        $model->bid_id = $_POST['bid_id'];
        $model->message = $_POST['message'];
        
        if(($bid_reply_id = $model->create()) !== false) {
            $data['status'] = 1;
            $bid_reply_vo = $this->bid_service->getBidReplyInfo($bid_reply_id);
            $data['view'] = BidReply::widget(['id' => 'bid-reply-' . $bid_reply_id, 'bid_reply' => $bid_reply_vo]);
           
        } else {
            $data['status'] = 0;
        }
        
        return json_encode($data);
    }
    
    
    public function actionGive() {
        $data = array();
        if(!Yii::$app->user->isGuest && isset($_POST['bid_id'])) {
            $model = new \frontend\models\GiveForm();
            $model->post_owner_id = Yii::$app->user->getId();
            $model->bid_id = $_POST['bid_id'];
            if($model->validate() && $model->give()) {
                $data['status'] = 1;
                return json_encode($data);
            }
        }        
        $data['status'] = 0;
        return json_encode($data);
    }
    
    
    public function actionCancelGive() {
        
        $data = array();
        if(!Yii::$app->user->isGuest && isset($_POST['bid_id'])) {
            $model = new \frontend\models\GiveForm();
            $model->post_owner_id = Yii::$app->user->getId();
            $model->bid_id = $_POST['bid_id'];
            if($model->validate() && $model->cancelGive()) {
                $data['status'] = 1;
                return json_encode($data);
            }
        }        
        $data['status'] = 0;
        return json_encode($data);
    }
    
    public function actionGetMoreReplies() {
        $data = array();
        if(!Yii::$app->user->isGuest && isset($_POST['bid_id']) && isset($_POST['first_created_at']) && isset($_POST['offset'])) {
            $bid_replies = $this->bid_service->getMoreReplies($_POST['bid_id'], $_POST['first_created_at'], $_POST['offset']);
            $data['status'] = 1;
            $data['count'] = count($bid_replies);
            $view = '';
            foreach($bid_replies as $bid_reply) {   
                $view .= BidReply::widget(['id' => 'bid-reply-' . $bid_reply->getBidReplyId(), 'bid_reply' => $bid_reply]);
            }
           
            $data['view'] = $view;
        }
        else {
            $data['status'] = 0;
        }
        
        return json_encode($data);
    }
}
