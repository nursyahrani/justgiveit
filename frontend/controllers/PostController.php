<?php
namespace frontend\controllers;

use frontend\models\CreateStuffForm;
use frontend\models\NotificationPostThanksForm;
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

    public function actionCreate() {
        return $this->render('create-post');
    }

    public function actionProcessCreate(){
        $data= array();
        if(!Yii::$app->user->isGuest  && isset($_POST['title']) &&
                isset($_POST['description']) && isset($_POST['tags']) 
                && isset($_POST['image_id'])) {
            
            $create_stuff_form = new CreateStuffForm();
            $create_stuff_form->poster_id = Yii::$app->user->getId();
            $create_stuff_form->title = $_POST['title'];
            $create_stuff_form->tags = $_POST['tags'];
            $create_stuff_form->description = $_POST['description'];
            $create_stuff_form->image_id = $_POST['image_id'];
            $create_stuff_form->quantity = $_POST['quantity'];
            $stuff_id =$create_stuff_form->create();
                
            if($stuff_id !== null) {
                $data['status'] = 1;
                $data['stuff_id'] = $stuff_id;
                return json_encode($data);
            }
            $data['message'] = $create_stuff_form->getErrors();
        }
        
        $data['status'] = 0;
        return json_encode($data);

    }
    
   
    
    public function actionIndex() {
        if(!isset($_GET['id'])) {
            Yii::$app->end('end');
        }
        $vo = $this->post_service->getPostInfo(Yii::$app->user->getId(), $_GET['id'], new \frontend\vo\PostVoBuilder());
        
        if($vo->getPostStatus() === '0') {
            return $this->render('delete');
        }
        return $this->render('index', ['post' => $vo]);
        
        
    }
    
    public function actionRequestFavorite() {
        $data = array();
        if(!Yii::$app->user->isGuest && isset($_POST['stuff_id'])) {
            $model = new FavoriteForm();
            $model->user_id = Yii::$app->user->getId();
            $model->stuff_id = $_POST['stuff_id'];
            
            if($model->validate() && $model->requestFavorite()) {
                $this->createNotificationPostThanks($_POST['stuff_id']);
                $data['status'] = 1;
                return json_encode($data);
            }
        }        

        $data['status'] = 0;
        return json_encode($data);
    }
    
    private function createNotificationPostThanks($post_id) {
        $notification_model = new NotificationPostThanksForm();
        $notification_model->post_id = $post_id;
        $notification_model->new_actor_id = Yii::$app->user->getId();
        $notification_model->create(NotificationPostForm::POST_THANKS);
    }
    
    private function deleteNotificationPostThanks($post_id) {
        $notification_model = new NotificationPostThanksForm();
        $notification_model->post_id = $post_id;
        $notification_model->new_actor_id = Yii::$app->user->getId();
        $notification_model->delete(NotificationPostThanksForm::POST_THANKS);
    }
    
    public function actionCancelFavorite() {
        $data = array();
        if(!Yii::$app->user->isGuest && isset($_POST['stuff_id'])) {
            
            $model = new FavoriteForm();
            $model->user_id = Yii::$app->user->getId();
            $model->stuff_id = $_POST['stuff_id'];
            if($model->validate() && $model->cancelFavorite()) {
                $this->deleteNotificationPostThanks($model->stuff_id);
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
               || !isset($_POST['stuff_id']) || !isset($_POST['tags'])  || !isset($_POST['quantity'])) {
            $data['status'] = 0;
            return json_encode($data);
        }
        
        $model = new \frontend\models\EditStuffInformationForm();
        $model->user_id = \Yii::$app->user->getId();
        $model->stuff_id = $_POST['stuff_id'];
        $model->tags = $_POST['tags'];
        $model->title = $_POST['title'];
        $model->quantity = $_POST['quantity'];
        $model->description = $_POST['description'];
        if($model->validate() && $model->update()) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
            $data['message'] = $model->getErrors();
        }
        return json_encode($data);
    }
    
    public function actionEditPostImage() {
        $data = array();
        if(!Yii::$app->user->isGuest && isset($_POST['image_id']) && isset($_POST['stuff_id'])) {
            $model = new \frontend\models\EditPostImageForm;
            $model->user_id = Yii::$app->user->getId();
            $model->image_id = $_POST['image_id'];
            $model->stuff_id = $_POST['stuff_id'];
            if($model->edit()) {
                $data['status'] = 1;
                return json_encode($data);
            }
            if($model->hasErrors()) {
                $data['error'] = $model->getErrors()[0];
            }
        }
        
        $data['status'] = 0;
        return json_encode($data);
    }
    
    public function actionDelete() {
        $data = array();
        if(!Yii::$app->user->isGuest && isset($_POST['stuff_id'])) {
            $model = new \frontend\models\DeleteStuffForm;
            $model->user_id = Yii::$app->user->getId();
            $model->stuff_id = $_POST['stuff_id'];
            if($model->delete()) {
                $data['status'] = 1;
                return json_encode($data);
            }
        }
        
        $data['status'] = 0;
        return json_encode($data);
    }
}
