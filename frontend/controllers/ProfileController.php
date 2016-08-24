<?php
namespace frontend\controllers;

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
    
    private function getProfileAndStuffListInfo($username) {
        return $this->profile_service->getProfileAndStuffList(\Yii::$app->user->getId(), $username);
    }
    
    private function getProfileAndBidListInfo($username) {
        return $this->profile_service->getProfileAndBidList($username);
    }
    
}
