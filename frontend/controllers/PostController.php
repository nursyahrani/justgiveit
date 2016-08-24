<?php
namespace frontend\controllers;

use frontend\models\CreateStuffForm;

use frontend\models\FavoriteForm;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use frontend\service\ServiceFactory;
/**
 * Site controller
 */
class PostController extends Controller
{
    
    private $service_factory;
    
    private $post_service;
    
    public function init() {
        $this->service_factory = new ServiceFactory();
        $this->post_service = $this->service_factory->getService(ServiceFactory::POST_SERVICE);
    }


    public function actionCreate(){
        $create_stuff_form = new CreateStuffForm();
        $create_stuff_form->poster_id = Yii::$app->user->getId();
        if($create_stuff_form->load(Yii::$app->request->post()) && $create_stuff_form->validate()){
            if($create_stuff_form->create() ) {
                    return $this->redirect(Yii::$app->request->baseUrl . '/');
            }
        }
   
        return $this->render('post-create', ['create_stuff_form' => $create_stuff_form]) ;
    }
    
    public function actionIndex() {
        if(!isset($_GET['id'])) {
            Yii::$app->end('end');
        }
        $vo = $this->post_service->getPostInfo(Yii::$app->user->getId(), $_GET['id'], new \frontend\vo\PostVoBuilder());
        return $this->render('index', ['post' => $vo]);
        
        
    }
    
    public function actionSendBid() {
        $response = array();
        if(Yii::$app->user->isGuest || !isset($_POST['stuff_id']) || !isset($_POST['message'])) {
            $response['status'] = 0;
        }
        
        $create_bid_form = new \frontend\models\CreateBidForm();
        $create_bid_form->proposer_id = Yii::$app->user->getId();
        $create_bid_form->stuff_id = $_POST['stuff_id'];
        $create_bid_form->message = $_POST['message'];
        if(!$create_bid_form->bid()) {
            $response['status'] = 0;
        } else {
            $response['status'] = 1;

        }
        return json_encode($response);

    }
    
    public function actionRequestFavorite() {
        $data = array();
        if(!Yii::$app->user->isGuest && isset($_POST['stuff_id'])) {
            $model = new FavoriteForm();
            $model->user_id = Yii::$app->user->getId();
            $model->stuff_id = $_POST['stuff_id'];
            
            if($model->validate() && $model->requestFavorite()) {
                
                $data['status'] = 1;
                return json_encode($data);
            }
        }        

        $data['status'] = 0;
        return json_encode($data);
    }
    
    
    public function actionCancelFavorite() {
        $data = array();
        if(!Yii::$app->user->isGuest && isset($_POST['stuff_id'])) {
            
            $model = new FavoriteForm();
            $model->user_id = Yii::$app->user->getId();
            $model->stuff_id = $_POST['stuff_id'];
            if($model->validate() && $model->cancelFavorite()) {
                $data['status'] = 1;
                return json_encode($data);
            }
        }        

        $data['status'] = 0;
        return json_encode($data);
        
        
    }
    
    public function actionGive() {
        $data = array();
        
        
        if(!Yii::$app->user->isGuest && isset($_POST['user_id']) && isset($_POST['stuff_id'])) {
            
            $model = new \frontend\models\GiveForm();
            $model->current_user_id = Yii::$app->user->getId();
            $model->stuff_id = $_POST['stuff_id'];
            $model->proposer_id =   $_POST['user_id'];
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
        
        
        if(!Yii::$app->user->isGuest && isset($_POST['user_id']) && isset($_POST['stuff_id'])) {
            
            $model = new \frontend\models\GiveForm();
            $model->current_user_id = Yii::$app->user->getId();
            $model->stuff_id = $_POST['stuff_id'];
            $model->proposer_id =   $_POST['user_id'];
            if($model->validate() && $model->cancelGive()) {
                $data['status'] = 1;
                return json_encode($data);
            }
        }        

        $data['status'] = 0;
        return json_encode($data);
        
    }
    
    public function actionEdit() {
        $data = array();
        if(Yii::$app->user->isGuest || !isset($_POST['title']) || !isset($_POST['description'])
               || !isset($_POST['stuff_id']) || !isset($_POST['tags'])) {
            $data['status'] = 0;
            return json_encode($data);
        }
        
        $model = new \frontend\models\EditStuffInformationForm();
        $model->user_id = \Yii::$app->user->getId();
        $model->stuff_id = $_POST['stuff_id'];
        $model->tags = $_POST['tags'];
        $model->title = $_POST['title'];
        $model->description = $_POST['description'];
        if($model->validate() && $model->update()) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
            $data['message'] = $model->getErrors();
        }
        return json_encode($data);
    }
}
