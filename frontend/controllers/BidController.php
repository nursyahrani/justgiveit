<?php
namespace frontend\controllers;

use frontend\models\CreateStuffForm;

use frontend\models\FavoriteForm;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
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
}
