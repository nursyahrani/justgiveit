<?php
namespace frontend\controllers;
use Yii;
use frontend\models\UpdateUserNameForm;
use frontend\models\UpdateUserIntroForm;
use frontend\models\UpdateUserCityForm;
use frontend\service\ServiceFactory;
use frontend\service\ProfileService;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * Site controller
 */
class ProfileController extends Controller
{
    
    const LIMIT = 1000;
    
    private $service_factory;
    
    private $profile_service;
    
    public function init() {
        $this->service_factory = new ServiceFactory();
        $this->profile_service = $this->service_factory->getService(ServiceFactory::PROFILE_SERVICE);
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }



    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'oAuthSuccess'],
            ],
        ];
    }

    public function actionIndex(){
        if(!isset($_GET['username'])){
            return false;
        }
        $username = $_GET['username'];
        if(!isset($_GET['request'])) {
            $profile = $this->getProfileAndStuffListInfo($username);
        } 
        else {
            $request = $_GET['request'];
            if($request === 'stuff') {
                $profile = $this->getProfileAndStuffListInfo($username);
            }
            else if ($request === 'bid') {
                $profile = $this->getProfileAndBidListInfo($username);
            }
        }
        return $this->render('index', ['profile' => $profile]);
        
    }
    
    public function actionGetMorePosts() {
        
    }
    
    private function getProfileAndStuffListInfo($username) {
        return $this->profile_service->getProfileAndStuffList(\Yii::$app->user->getId(), $username, self::LIMIT);
    }
    
    private function getProfileAndBidListInfo($username) {
        return $this->profile_service->getProfileAndBidList($username, self::LIMIT);
    }
    
    public function actionUpdateIntro() {
        $data = array();
        if(!isset($_POST['intro']) || Yii::$app->user->isGuest) {
            $data['status'] = 0;
            return json_encode($data);
        }
        
        $model = new UpdateUserIntroForm();
        $model->intro = $_POST['intro'];
        $model->user_id = Yii::$app->user->getId();
        if($model->update()) {
            $data['status'] = 1;
            return json_encode($data);
        }
        
        $data['status'] = 0;
        $data['error'] = $model->getErrors();
        
        return json_encode($data);
        
    }
    
    public function actionUpdateName() {
        $data = array();
        if(!isset($_POST['first_name']) || Yii::$app->user->isGuest) {
            $data['status'] = 0;
            return json_encode($data);
        }
        
        $model = new UpdateUserNameForm;
        $model->first_name = $_POST['first_name'];
        $model->last_name = isset($_POST['last_name']) ? 
                $_POST['last_name'] : '';
        $model->user_id = Yii::$app->user->getId();
        
        if($model->update()) {
            $data['status'] = 1;
            return json_encode($data);
        }
        
        $data['status'] = 0;
        return json_encode($data);
         
    }
    
    public function actionUpdateCity() {
        $data = array();
        if(!isset($_POST['city_id']) || Yii::$app->user->isGuest) {
            $data['status'] = 0;
            return json_encode($data);
        }
        
        $model = new UpdateUserCityForm();
        $model->city_id = $_POST['city_id'];
        $model->user_id = Yii::$app->user->getId();
        if($model->update()) {
            $data['status'] = 1;
            return json_encode($data);
        }
        $data['status'] = 0;
        if($model->hasErrors()) {
            $data['error'] = $model->getErrors();
        }
        return json_encode($data);
    }
}
