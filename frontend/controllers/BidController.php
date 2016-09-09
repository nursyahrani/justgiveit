<?php
namespace frontend\controllers;

use Yii;
use frontend\models\NotificationBidApprovalForm;
use frontend\models\NotificationBidProposalForm;
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
    
    public function actionIndex() {
        
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
            $this->createBidReplyNotification($model->bid_id);
            $bid_reply_vo = $this->bid_service->getBidReplyInfo($bid_reply_id);
            $data['view'] = BidReply::widget(['id' => 'bid-reply-' . $bid_reply_id, 'bid_reply' => $bid_reply_vo]);
           
        } else {
            $data['status'] = 0;
        }
        
        return json_encode($data);
    }
    
    private function createBidReplyNotification($bid_id) {
        $notification = new \frontend\models\NotificationBidReplyForm;
        $notification->bid_id = $bid_id;
        $notification->new_actor_id = Yii::$app->user->getId();
        $notification->create();
    }
    
    
    public function actionDelete() {
        $data = array();
        if(!Yii::$app->user->isGuest && isset($_POST['bid_id'])) {
            $model = new \frontend\models\DeleteBidForm;
            $model->user_id = Yii::$app->user->getId();
            $model->bid_id = $_POST['bid_id'];
            $result = $model->delete();
            if($result !== false) {
                $data['status'] = 1;
                return json_encode($data);
               
            } 
        }
        
        $data['status'] = 0;
        return json_encode($data);
    }
    
    
    public function actionGive() {
        $data = array();
        if(!Yii::$app->user->isGuest && isset($_POST['bid_id'])) {
            $model = new \frontend\models\GiveForm();
            $model->post_owner_id = Yii::$app->user->getId();
            $model->bid_id = $_POST['bid_id'];
            if($model->validate() && $model->give()) {
                $this->createNotificationBidApprovalForm($model->bid_id);
                $data['status'] = 1;
                return json_encode($data);
            }
        }        
        $data['status'] = 0;
        return json_encode($data);
    }
    
    private function createNotificationBidApprovalForm($bid_id) {
        $notification = new NotificationBidApprovalForm;
        $notification->new_actor_id = Yii::$app->user->getId();
        $notification->bid_id = $bid_id;
        $notification->create();
    }
    
    
    public function actionCancelGive() {
        
        $data = array();
        if(!Yii::$app->user->isGuest && isset($_POST['bid_id'])) {
            $model = new \frontend\models\GiveForm();
            $model->post_owner_id = Yii::$app->user->getId();
            $model->bid_id = $_POST['bid_id'];
            if($model->validate() && $model->cancelGive()) {
                $this->deleteNotificationBidApprovalForm($model->bid_id);
                $data['status'] = 1;
                return json_encode($data);
            }
        }        
        $data['status'] = 0;
        return json_encode($data);
    }
    
    private function deleteNotificationBidApprovalForm($bid_id) {
        $notification = new NotificationBidApprovalForm;
        $notification->new_actor_id = Yii::$app->user->getId();
        $notification->bid_id = $bid_id;
        $notification->delete();
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
    
    
    public function actionSendBid() {
        $response = array();
        if(Yii::$app->user->isGuest || !isset($_POST['stuff_id']) || !isset($_POST['message']) || !isset($_POST['quantity'])) {
            $response['status'] = 0;
            $response['error'] = 'Requirements Failure';
            return json_encode($response);
        }
        
        $create_bid_form = new \frontend\models\CreateBidForm();
        $create_bid_form->proposer_id = Yii::$app->user->getId();
        $create_bid_form->stuff_id = $_POST['stuff_id'];
        $create_bid_form->message = $_POST['message'];
        $create_bid_form->quantity = $_POST['quantity'];
        if(!$create_bid_form->bid()) {
            $response['status'] = 0;
            $error = '';
            if($create_bid_form->hasErrors()) {
                $error = $create_bid_form->getErrors()[0];
            }
            $response['error'] = 'Fail to update server: ' . $error;
        } else {
            $response['status'] = 1;

        }
        $this->createBidProposalNotification($create_bid_form->stuff_id);
        return json_encode($response);

    }
    
    private function createBidProposalNotification($post_id) {
        $notification_model = new NotificationBidProposalForm();
        $notification_model->post_id = $post_id;
        $notification_model->new_actor_id = Yii::$app->user->getId();
        $notification_model->create();
    }
    
    private function deleteBidProposalNotification($post_id) {
        $notification_model = new NotificationBidProposalForm();
        $notification_model->post_id = $post_id;
        $notification_model->new_actor_id = Yii::$app->user->getId();
        $notification_model->delete();
        
    }
    
}
