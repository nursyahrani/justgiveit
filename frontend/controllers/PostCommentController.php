<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\service\ServiceFactory;
/**
 * Site controller
 */
class PostCommentController extends Controller
{
    
    private $service_factory;
    
    private $post_comment_service;
    
    public function init() {
        $this->service_factory = new ServiceFactory();
        $this->post_comment_service = $this->service_factory->getService(ServiceFactory::POST_COMMENT_SERVICE);
    }
    
    public  function actionCreate() {
        $data = array();
        if(!Yii::$app->user->isGuest && isset($_POST['message']) && isset($_POST['post_id'])) {
            $model = new \frontend\models\CreateCommentForm;
            $model->user_id = Yii::$app->user->getId();
            $model->message = $_POST['message'];
            $model->post_id = $_POST['post_id'];
            $comment_id = $model->create();
            if($comment_id !== false) {
                $data['status'] = 1;
                return json_encode($data);
               
            } 
        }
        
        $data['status'] = 0;
        return json_encode($data);
    }
}
